<?php

namespace App\Controllers\Auth;

use Hleb\Constructor\Handlers\Request;
use App\Controllers\Controller;
use App\Models\User\{InvitationModel, UserModel};
use App\Validate\RulesRegistration;
use SendEmail, Meta, Html, UserData;

class RegisterController extends Controller
{
    // Show registration form
    // Показ формы регистрации
    public function showRegisterForm()
    {
        // If the invite system is enabled
        if (config('general.invite') == true) {
            redirect('/invite');
        }

        $m = [
            'og'    => false,
            'url'   => url('register'),
        ];

        return $this->render(
            '/auth/register',
            [
                'meta'  => Meta::get(__('app.registration'), __('help.security_info'), $m),
                'data'  => [
                    'sheet' => 'registration',
                    'type'  => 'register'
                ]
            ]
        );
    }

    public function index()
    {
        $inv_user_id  = Request::getPostInt('invitation_id');
        $reg_ip  = Request::getRemoteAddress();
        $data    = Request::getPost();
        $inv_uid = RulesRegistration::rules($data, $reg_ip, $inv_user_id);

        // For "launch mode", the first 50 members get trust_level = 2
        // Для "режима запуска" первые 50 участников получают trust_level = 2 
        $tl = UserData::USER_FIRST_LEVEL;
        if (UserModel::getUsersAllCount() < 50 && config('general.mode') == true) {
            $tl = UserData::USER_SECOND_LEVEL;
        }

        $active_uid = UserModel::create(
            [
                'login'                => $data['login'],
                'email'                => $data['email'],
                'template'             => config('general.template'),
                'lang'                 => config('general.lang'),
                'whisper'              => '',
                'password'             => password_hash($data['password'], PASSWORD_BCRYPT),
                'limiting_mode'        => 0, // режим заморозки выключен
                'activated'            => $inv_uid > 0 ? 1 : 0, // если инвайта нет, то активация
                'reg_ip'               => $reg_ip,
                'trust_level'          => $tl,
                'invitation_id'        => $inv_uid,
            ]
        );

        if ($inv_uid > 0) {
            // If registration by invite, activate the email
            // Если регистрация по инвайту, активируем емайл
            InvitationModel::activate(
                [
                    'uid'               => $inv_uid,
                    'active_status'     => 1,
                    'active_ip'         => $reg_ip,
                    'active_time'       => date('Y-m-d H:i:s'),
                    'active_uid'        => $active_uid,
                    'invitation_code'   => $data['invitation_code'],
                ]
            );

            is_return(__('msg.change_saved'), 'success', url('login'));
        }

        // Email Activation
        $email_code = Html::randomString('crypto', 20);
        UserModel::sendActivateEmail(
            [
                'user_id'       => $active_uid,
                'email_code'    => $email_code,
            ]
        );

        // Sending email
        SendEmail::mailText($active_uid, 'activate.email', ['link' => url('activate.code', ['code' => $email_code])]);

        is_return(__('msg.check_your_email'), 'success', url('login'));
    }

    // Show registration form with invite
    // Показ формы регистрации с инвайтом
    public function showInviteForm()
    {
        $code   = Request::get('code');
        $invate = InvitationModel::available($code);

        if (!$invate) {
            is_return(__('msg.code_incorrect'), 'error', '/');
        }

        return $this->render(
            '/auth/register-invate',
            [
                'meta'  => Meta::get(__('app.reg_invite')),
                'data'  => [
                    'invate' => $invate,
                    'type'  => 'invite'
                ]
            ]
        );
    }
}
