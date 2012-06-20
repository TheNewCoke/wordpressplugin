<?php

/**
 * This is an HTML template file for the Grid Widget. This template is meant to wrap a 
 * set of listing views. This file should ideally contain very little PHP.
 * 
 * @package       com.mlsfinder.wordpress
 * @subpackage    listing.template
 * @title         listingGrid.php
 * @contributors  AJ Michels (aj.michels@wolfnet.com)
 * @version       1.0
 * @copyright     Copyright (c) 2012, WolfNet Technologies, LLC
 * 
 */

?>

<div id="<?php echo $instanceId; ?>" class="mlsFinder_widget mlsFinder_listingGrid">
	<?php echo ( isset($listingContent) ) ? $listingContent : 'No Listings to Display.'; ?>
	<div class="clearfix"></div>
</div>

<script type="text/javascript">
	
	jQuery( '#<?php echo $instanceId; ?>' ).wntListingGrid( {} );
	
</script>