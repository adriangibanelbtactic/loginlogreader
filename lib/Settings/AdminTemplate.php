<?php
/**
 * Login Log Reader
 * Copyright (C) 2024 BTACTIC, S.C.C.L.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace OCA\LoginLogReader\Settings;

use OCA\LoginLogReader\AppInfo\Application;
use OCP\AppFramework\Http\TemplateResponse;

class AdminTemplate
{
    /**
     * @var AppSettings
     */
    private $appConfig;

    public function __construct(AppSettings $appConfig)
    {
        $this->appConfig = $appConfig;
        $this->zimbraAuthentication = $zimbraAuthentication;
    }

    /**
     * @return TemplateResponse
     */
    public function getTemplate()
    {
        $logfile = $this->get_log_filename();

        $template = new TemplateResponse(
            Application::APP_ID,
            'admin',
            [
                'logfile' => $this->appConfig->getLogFile()
            ],
            'blank'
        );

        return $template;
    }
}
