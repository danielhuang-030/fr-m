<?php

namespace App\Presenters;

use Storage;

class UserPresenter
{
    /**
     * default image
     *
     * @var string
     */
    const DEFAULT_IMAGE = '/images/avatar.png';

    public function getAvatarLink($link)
    {
        if (empty($link)) {
            $link = url(static::DEFAULT_IMAGE);
        }
        return starts_with($link, 'http') ? $link : Storage::disk('public')->url($link);
    }

    public function getStatusSpan($status)
    {
        $class = $this->isActive($status) ? 'label-success' : 'label-info';
        $span = $this->isActive($status) ? 'activated' : 'deactivated';

        $html = <<<html
<span class="label {$class}">{$span}</span>
html;

        return $html;
    }

    public function getThumbLink($link)
    {
        return starts_with($link, 'http') ? $link : Storage::disk('public')->url($link);
    }

    public function getHiddenPartName($name)
    {
        $lastStr = mb_substr($name, 0, 1, 'utf-8');

        $hiddenStr = str_repeat('*', mb_strlen($name, 'utf-8') - 1);

        return $lastStr . $hiddenStr;
    }

    public function isActive($status)
    {
        return $status == 1;
    }
}