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

use OCP\IConfig;
use OCP\App\IAppManager;

class AppSettings
{

    /** @var IConfig */
    private $config;

    /** @var IAppManager */
    private $appManager;

    /**
     * AppSettings constructor.
     * @param $config
     * @param $appManager
     */
    public function __construct(IConfig $config, IAppManager $appManager)
    {
        $this->config = $config;
        $this->appManager = $appManager;
    }

    public function getLogFile()
    {
        $config = $this->config;

		$auditType = $config->getSystemValueString('log_type_audit', 'file');
		$logFile = $config->getSystemValueString('logfile_audit', '');

		if ($auditType === 'file' && !$logFile) {
			$default = $config->getSystemValue('datadirectory', \OC::$SERVERROOT . '/data') . '/audit.log';
			// Legacy way was appconfig, now it's paralleled with the normal log config
			$logFile = $config->getAppValue('admin_audit', 'logfile', $default);
		}

		return ($logFile);
    }

    public function adminAuditIsInstalled()
    {
        return ($this->appManager->isInstalled('admin_audit'));
    }

}
