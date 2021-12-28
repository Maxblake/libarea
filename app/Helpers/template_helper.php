<?php

/*
 * Matching names for the functions used.
 *
 * Сопоставление названий для используемых функций.
 */

function agTheme($user_theme, $file)
{
    $tpl_puth = $user_theme . $file;
    if (!file_exists(TEMPLATES . DIRECTORY_SEPARATOR . $user_theme . $file . '.php')) {
        $tpl_puth = Config::get('general.template') . $file;
    }

    return $tpl_puth;
}

function agRender($name, $data = null)
{
    return render(
        [
            agTheme($data['uid']['user_template'], '/header'),
            agTheme($data['uid']['user_template'], '/content' . $name),
            agTheme($data['uid']['user_template'], '/footer')
        ],
        $data
    );
}

function agIncludeCachedTemplate(string $template, array $params = [])
{
    hleb_include_cached_template(agTheme($params['uid']['user_template'], $template), $params);
}

function agIncludeTemplate(string $template, array $params = [])
{
    return hleb_include_template(agTheme($params['uid']['user_template'], $template), $params);
}

function import($template, array $params = [])
{
    $uid = \Base::getUid();
    insertTemplate($uid['user_template'] . $template, $params);
}