<?php
/*
 * vim:set softtabstop=4 shiftwidth=4 expandtab:
 *
 * LICENSE: GNU Affero General Public License, version 3 (AGPL-3.0-or-later)
 * Copyright 2001 - 2020 Ampache.org
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

declare(strict_types=1);

namespace Ampache\Module\Util;

use Ampache\Config\ConfigContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Factory to create utility classes like Mailer
 */
final class UtilityFactory implements UtilityFactoryInterface
{
    private ConfigContainerInterface $configContainer;

    private LoggerInterface $logger;

    public function __construct(
        ConfigContainerInterface $configContainer,
        LoggerInterface $logger
    ) {
        $this->configContainer = $configContainer;
        $this->logger          = $logger;
    }

    public function createMailer(): MailerInterface
    {
        return new Mailer();
    }

    public function createVaInfo(
        $file,
        $gather_types = array(),
        $encoding = null,
        $encoding_id3v1 = null,
        $encoding_id3v2 = null,
        $dir_pattern = '',
        $file_pattern = '',
        $islocal = true
    ): VaInfoInterface {
        return new VaInfo(
            $file,
            $gather_types = array(),
            $encoding = null,
            $encoding_id3v1 = null,
            $encoding_id3v2 = null,
            $dir_pattern = '',
            $file_pattern = '',
            $islocal = true,
            $this->configContainer,
            $this->logger
        );
    }
}
