<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy\Panel\Auth;

use BeastBytes\Yii\Tracy\Panel\Panel;
use Yiisoft\User\CurrentUser;

class Auth extends Panel
{
    private const string ICON_AUTHORISED = <<<ICON
<svg 
    xmlns="http://www.w3.org/2000/svg"
    height="24px"
    viewBox="0 -960 960 960"
    width="24px"
    fill="#5ea500"
>
    <path
        d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34
        17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5
        43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5
        14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5
        56.5T480-560Zm0-80Zm0 400Z"
    />
</svg>
ICON;

    private const ICON_GUEST = <<<ICON
<svg
    xmlns="http://www.w3.org/2000/svg"
    height="24px"
    viewBox="0 -960 960 960"
    width="24px"
    fill="#404040"
>
    <path 
        d="M791-55 686-160H160v-112q0-34 17.5-62.5T224-378q45-23 91.5-37t94.5-21L55-791l57-57 736 736-57 
        57ZM240-240h366L486-360h-6q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm496-138q29 14 46 42.5t18 
        61.5L666-408q18 7 35.5 14t34.5 16ZM568-506l-59-59q23-9 37-29.5t14-45.5q0-33-23.5-56.5T480-720q-25 0-45.5 
        14T405-669l-59-59q23-34 58-53t76-19q66 0 113 47t47 113q0 41-19 76t-53 58Zm38 266H240h366ZM457-617Z"
    />
</svg> 
ICON;

    private const string TITLE = 'Current User';

    private ?CurrentUser $currentUser = null;

    public function panelParameters(): array
    {
        return [
            'currentUser' => $this->getCurrentUser(),
        ];
    }

    public function panelTitle(): string
    {
        return self::TITLE;
    }

    /**
     * @param array $parameters
     * @psalm-param array{
     *     currentUser: CurrentUser
     * }
     * @return string
     */
    public function tabIcon(array $parameters): string
    {
        return $parameters['currentUser']->isGuest()
            ? self::ICON_GUEST
            : self::ICON_AUTHORISED
        ;
    }

    public function tabParameters(): array
    {
        return [
            'currentUser' => $this->getCurrentUser(),
        ];
    }

    public function tabTitle(): string
    {
        return self::TITLE;
    }

    private function getCurrentUser(): CurrentUser
    {
        if ($this->currentUser === null) {
            $this->currentUser = $this->container->get(CurrentUser::class);
        }

        return $this->currentUser;
    }
}