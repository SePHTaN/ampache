<?php
/*
 * vim:set softtabstop=4 shiftwidth=4 expandtab:
 *
 *  LICENSE: GNU Affero General Public License, version 3 (AGPL-3.0-or-later)
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

namespace Ampache\Gui;

use Ampache\Config\ConfigContainerInterface;
use Ampache\Gui\Catalog\CatalogDetails;
use Ampache\Gui\Playlist\NewPlaylistDialogAdapter;
use Ampache\Gui\Song\SongViewAdapter;
use Ampache\Gui\Stats\CatalogStats;
use Ampache\Gui\Stats\StatsViewAdapter;
use Ampache\Gui\System\ConfigViewAdapter;
use Ampache\Gui\System\UpdateViewAdapter;
use Ampache\MockeryTestCase;
use Ampache\Model\Catalog;
use Ampache\Model\ModelFactoryInterface;
use Ampache\Model\Song;
use Ampache\Module\Authorization\GuiGatekeeperInterface;
use Ampache\Module\Playlist\PlaylistLoaderInterface;
use Ampache\Module\Util\AjaxUriRetrieverInterface;
use Ampache\Repository\VideoRepositoryInterface;
use Mockery\MockInterface;

class GuiFactoryTest extends MockeryTestCase
{
    /** @var MockInterface|ConfigContainerInterface|null */
    private MockInterface $configContainer;

    /** @var MockInterface|ModelFactoryInterface|null */
    private MockInterface $modelFactory;

    /** @var MockInterface|AjaxUriRetrieverInterface|null */
    private MockInterface $ajaxUriRetriever;

    /** @var MockInterface|PlaylistLoaderInterface|null */
    private MockInterface $playlistLoader;

    /** @var MockInterface|VideoRepositoryInterface|null */
    private MockInterface $videoRepository;
    
    /** @var GuiFactory|null */
    private GuiFactory $subject;
    
    public function setUp(): void
    {
        $this->configContainer  = $this->mock(ConfigContainerInterface::class);
        $this->modelFactory     = $this->mock(ModelFactoryInterface::class);
        $this->ajaxUriRetriever = $this->mock(AjaxUriRetrieverInterface::class);
        $this->playlistLoader   = $this->mock(PlaylistLoaderInterface::class);
        $this->videoRepository  = $this->mock(VideoRepositoryInterface::class);
        
        $this->subject = new GuiFactory(
            $this->configContainer,
            $this->modelFactory,
            $this->ajaxUriRetriever,
            $this->playlistLoader,
            $this->videoRepository
        );
    }

    public function testCreateSongViewAdapterReturnsInstance(): void
    {
        $this->assertInstanceOf(
            SongViewAdapter::class,
            $this->subject->createSongViewAdapter(
                $this->mock(GuiGatekeeperInterface::class),
                $this->mock(Song::class)
            )
        );
    }
    
    public function testCreateConfigViewAdapterReturnsInstance(): void
    {
        $this->assertInstanceOf(
            ConfigViewAdapter::class,
            $this->subject->createConfigViewAdapter()
        );
    }
    
    public function testCreateStatsViewAdapterReturnsInstance(): void
    {
        $this->assertInstanceOf(
            StatsViewAdapter::class,
            $this->subject->createStatsViewAdapter()
        );
    }
    
    public function testCreateCatalogDetailsReturnsInstance(): void
    {
        $this->assertInstanceOf(
            CatalogDetails::class,
            $this->subject->createCatalogDetails(
                $this->mock(Catalog::class)
            )
        );
    }
    
    public function testCreateCatalogStatsReturnsInstance(): void
    {
        $this->assertInstanceOf(
            CatalogStats::class,
            $this->subject->createCatalogStats([])
        );
    }

    public function testCreateUpdateViewAdapterReturnsInstance(): void
    {
        $this->assertInstanceOf(
            UpdateViewAdapter::class,
            $this->subject->createUpdateViewAdapter()
        );
    }

    public function testCreateNewPlaylistDialogAdapterReturnsInstance(): void
    {
        $this->assertInstanceOf(
            NewPlaylistDialogAdapter::class,
            $this->subject->createNewPlaylistDialogAdapter(
                $this->mock(GuiGatekeeperInterface::class),
                'some-type',
                666
            )
        );
    }
}
