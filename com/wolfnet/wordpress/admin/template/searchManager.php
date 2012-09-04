<?php

/**
 * This is an HTML template file for the Plugin search manager page in the WordPress admin. This
 * file should ideally contain very little PHP.
 *
 * @package       com.wolfnet.wordpress
 * @subpackage    admin.template
 * @title         searchManager.php
 * @contributors  AJ Michels (aj.michels@wolfnet.com)
 * @version       1.0
 * @copyright     Copyright (c) 2012, WolfNet Technologies, LLC
 *
 */

?>
<div class="wrap">

	<div id="icon-options-wolfnet" class="icon32"><br></div>

	<h2>WolfNet - Search Manager</h2>

	<noscript>
		<div class="error">
			This page will not work without JavaScript enabled.
		</div>
	</noscript>

	<div style="width:875px">

		<p>The <strong>search manager</strong> allows you to create easily create and save custom search
			criteria which you can then use for defining shortcodes and widgets. The wordpress search
			manager works much the same way as the custom URL Search Builder within the MLS Finder
			Admin.</p>

		<p>Custom searches can target any of the search criteria that is available on your property
			search. Keep in mind that some search criteria is more restrictive than others, which means
			less results will be produced. Use the <strong>Results</strong> feature to determine how
			restrictive a search may be. NOTE: the search criteria available on your property search
			is based on the data available in the feed from your MLS. This data is subject to change,
			which may affect custom search strings you generate. WolfNet recommends that you
			periodically review your custom searches to verify that they still produce the expected
			results. If not, you may need to revisit the search manager and create a new custom search.</p>

	</div>

	<?php echo $search_form; ?>

	<style type="text/css">
		/* Fixing issue caused by wolfnet search builder css */
		body {
			background-color: transparent !important;
		}
	</style>

	<div id="savedsearches" class="style_box">
		<div class="style_box_header">Saved Searches</div>
		<div class="style_box_content">
			<table style="width:100%;">
				<thead>
					<tr>
						<th style="text-align:left;">Description</th>
						<th style="wwidth:200px;">Date Created</th>
						<th style="width:110px;"></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"><input type="text" title="Description" style="width:100%;" /></td>
						<td style="text-align:center;"><button>Save Search</button></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

</div>

<script type="text/javascript">

	 /* Make sure the 'trim' function is available in the String object. Fix for older versions of IE. */
	if(typeof String.prototype.trim !== 'function') {
		String.prototype.trim = function() {
			return this.replace(/^\s+|\s+$/g, '');
		}
	}

	( function ( $ ) {

		var savedSearches = {};
		var $container    = $( '#savedsearches' );
		var $tbody        = $container.find( 'tbody:first' );
		var $form         = $container.find( 'tfoot:first' );
		var $desc         = $form.find( 'input:first' );
		var $save         = $form.find( 'button:first' );
		var idprefix      = 'savedsearch_';
		var apiUrl        = '<?php echo bloginfo( 'url' ); ?>/?pagename=wolfnet-admin-searchmanager';
		var apiGetUrl     = apiUrl + '-get';
		var apiPostUrl    = apiUrl + '-save';
		var apiDeleteUrl  = apiUrl + '-delete';
		var loaded        = false;
		var saving        = false;
		var loaderUri     = '<?php echo $pluginUrl; ?>img/loader.gif';
		var $loaderImage  = $container.find( '#loader:first' );

		var createLoaderImage = function ()
		{

			/* If the window element doesn't exist create it and add it to the page. */
			if ( $loaderImage.length == 0 ) {
				$loaderImage = $( '<div/>' );
				$loaderImage.append( $( '<img src="' + loaderUri + '" />' ) );
				$loaderImage.attr( 'id', 'loader' );
				$loaderImage.addClass( 'wolfnet_loaderImage' );
				$loaderImage.hide();
				$loaderImage.appendTo( $container );
			}
		}

		var getData = function ()
		{
			$.ajax( {
				url: apiGetUrl,
				dataType: 'json',
				type: 'GET',
				beforeSend: function () {
					$loaderImage.show();
				},
				success: function ( data ) {
					savedSearches = data;
					refreshTable();
				},
				complete: function () {
					$loaderImage.hide();
					loaded = true;
				}
			} );
		}

		var saveSearch = function ()
		{
			if ( loaded && !saving ) {
				if ( $desc.val().trim() == '' ) {
					$desc.addClass( 'invalid' );
					alert( 'You must specify a description to save your search.' );
				}
				else {

					$desc.removeClass( 'invalid' );

					$.ajax( {
						url: apiPostUrl,
						dataType: 'json',
						type: 'POST',
						data: {
							post_title    : $desc.val(),
							custom_fields : WNTWP.returnSearchParams()
						},
						beforeSend: function () {
							$loaderImage.show();
							saving = true;
						},
						success: function ( data ) {
							savedSearches = data;
							refreshTable();
						},
						complete: function () {
							$loaderImage.hide();
							saving = false;
						}
					} );

					$desc.val( '' );

				}
			}
			else {
				alert( 'Cannot save, please wait until the data has updated.' );
			}

		}

		var deleteSearch = function ()
		{
			if ( loaded && !saving ) {
				var $this = $( this );
				var $row  = $this.closest( 'tr' );
				var id    = $row.attr( 'id' ).replace( idprefix, '' );

				$.ajax( {
					url: apiDeleteUrl,
					dataType: 'json',
					type: 'GET',
					data: {
						ID : id
					},
					beforeSend: function () {
						$loaderImage.show();
						saving = true;
					},
					success: function ( data ) {
						savedSearches = data;
						refreshTable();
					},
					complete: function () {
						$loaderImage.hide();
						saving = false;
					}
				} );

			}
			else {
				alert( 'Cannot delete, please wait until the data has updated.' );
			}
		}

		var refreshTable = function ()
		{
			var $row, $descCell, $cdateCell, $ctrlCell, $delBtn;

			$tbody.children().remove();

			for ( var i in savedSearches ) {

				$row = $( '<tr/>' );
				$row.attr( 'id', idprefix + savedSearches[i].ID );
				$row.addClass( 'savedsearch' );
				$row.appendTo( $tbody );

				$descCell = $( '<td/>' );
				$descCell.html( savedSearches[i].post_title );
				$descCell.appendTo( $row );

				$cdateCell = $( '<td/>' );
				$cdateCell.html( savedSearches[i].post_date );
				$cdateCell.appendTo( $row );

				$ctrlCell = $( '<td/>' );
				$ctrlCell.appendTo( $row );

				$delBtn = $( '<button/>' );
				$delBtn.html( 'Delete' );
				$delBtn.appendTo( $ctrlCell );
				$delBtn.click( deleteSearch );

			}

		}

		$save.click( saveSearch );
		$desc.keypress( function ( event ) {
			if ( event.keyCode == 13 ) {
				saveSearch();
			}
		} );
		$( document ).ready( function () {
			createLoaderImage();
			getData();
		} );

	} )( jQuery );

</script>
