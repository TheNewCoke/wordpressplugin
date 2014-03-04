<?php

/**
 *
 * @title         PropertyListWidget.php
 * @copyright     Copyright (c) 2012, 2013, WolfNet Technologies, LLC
 *
 *                This program is free software; you can redistribute it and/or
 *                modify it under the terms of the GNU General Public License
 *                as published by the Free Software Foundation; either version 2
 *                of the License, or (at your option) any later version.
 *
 *                This program is distributed in the hope that it will be useful,
 *                but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *                GNU General Public License for more details.
 *
 *                You should have received a copy of the GNU General Public License
 *                along with this program; if not, write to the Free Software
 *                Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

class Wolfnet_ResultsSummaryWidget extends Wolfnet_ListingGridWidget
{


    public $idBase = 'wolfnet_resultsSummaryWidget';

    public $name = 'WolfNet Results Summary';

    public $options = array(
        'description' => 'Define criteria to display a results summary of matching properties. The summary includes an image, price, number of bedrooms, number of bathrooms, and address.'
        );


    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        echo $this->plugin->resultsSummary($this->collectData($args, $instance));
        echo $args['after_widget'];

    }

}