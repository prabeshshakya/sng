<?php 
/**
	Admin Page Framework v3.8.7b02 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/custom-scrollbar>
	Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class CustomScrollbar_AdminPageFramework_Form_View___Script_CollapsibleSection extends CustomScrollbar_AdminPageFramework_Form_View___Script_Base {
    public function construct() {
        wp_enqueue_script('juery');
        wp_enqueue_script('juery-ui-accordion');
    }
    static public function getScript() {
        $_aParams = func_get_args() + array(null);
        $_oMsg = $_aParams[0];
        $_sToggleAllButtonHTML = '"' . self::_getToggleAllButtonHTML($_oMsg) . '"';
        return <<<JAVASCRIPTS
( function( $ ) {

    jQuery( document ).ready( function() {
        jQuery( this ).initializeCustomScrollbar_AdminPageFrameworkCollapsibleSections();
    });              

    /**
     * Gets triggered when a widget of the framework is saved.
     * @since    3.7.0
     */
    jQuery( document ).bind( 'custom-scrollbar_saved_widget', function( event, oWidget ){
        jQuery( oWidget ).initializeCustomScrollbar_AdminPageFrameworkCollapsibleSections();
    });    
    
    $.fn.initializeCustomScrollbar_AdminPageFrameworkCollapsibleSections = function() {
        
        // Expand collapsible sections that are set not to collapse by default 
        jQuery( this ).find( '.custom-scrollbar-collapsible-sections-title[data-is_collapsed=\"0\"]' )
            .next( '.custom-scrollbar-collapsible-sections-content' )
            .slideDown( 'fast' );
        jQuery( this ).find( '.custom-scrollbar-collapsible-section-title[data-is_collapsed=\"0\"]' )
            .closest( '.custom-scrollbar-section-table' )
            .find( 'tbody' )
            .slideDown( 'fast' );
            
        // Hide collapsible sections of 'section' containers as they are somehow do not get collapsed by default.
        jQuery( this ).find( '.custom-scrollbar-collapsible-section-title[data-is_collapsed=\"1\"]' )
            .closest( '.custom-scrollbar-section-table' )
            .find( 'tbody' )
            .hide();
        
        // Bind the click event to the title element.
        jQuery( this ).find( '.custom-scrollbar-collapsible-sections-title, .custom-scrollbar-collapsible-section-title' ).enableCustomScrollbar_AdminPageFrameworkCollapsibleButton();
        
        // Insert the toggle all button.
        jQuery( this ).find( '.custom-scrollbar-collapsible-title[data-toggle_all_button!=\"0\"]' ).each( function(){
            
            var _oThis        = jQuery( this ); // to access from inside the below each() method.
            var _bForSections = jQuery( this ).hasClass( 'custom-scrollbar-collapsible-sections-title' );   // or for the 'section' container.
            var _isPositions  = jQuery( this ).data( 'toggle_all_button' );
            var _isPositions  = 1 === _isPositions
                ? 'top-right'   // default
                : _isPositions;
            var _aPositions   = 'string' === typeof _isPositions
                ? _isPositions.split( ',' )
                : [ 'top-right' ];

            jQuery.each( _aPositions, function( iIndex, _sPosition ) {
         
                var _oButton = jQuery( $_sToggleAllButtonHTML );
                var _sLeftOrRight = -1 !== jQuery.inArray( _sPosition, [ 'top-right', 'bottom-right', '0' ] )   // if found
                    ? 'right'   // default
                    : 'left';            
                _oButton.find( '.custom-scrollbar-collapsible-toggle-all-button' ).css( 'float', _sLeftOrRight );

                var _sTopOrBottom = -1 !== jQuery.inArray( _sPosition, [ 'top-right', 'top-left', '0' ] )   // if found
                    ? 'before'   // default
                    : 'after';            
                
                // Insert the button - there are two versions: for the sections container or the section container.
                if ( _bForSections ) {
                    var _oTargetElement = 'before' === _sTopOrBottom
                        ? _oThis
                        : _oThis.next( '.custom-scrollbar-collapsible-content' );
                        _oTargetElement[ _sTopOrBottom ]( _oButton );
                } else {    // for 'section' containers
                    _oThis.closest( '.custom-scrollbar-section' )[ _sTopOrBottom ]( _oButton );
                }                
                
                // Expand or collapse this panel
                jQuery( _oButton ).unbind( 'click' );       // for initially dropped (created) widgets
                _oButton.click( function(){                  
                    
                    var _oButtons = _bForSections
                        ? jQuery( this ).closest( '.custom-scrollbar-sectionset' ).siblings().andSelf().find( '> .custom-scrollbar-collapsible-toggle-all-button-container' )
                        : jQuery( this ).siblings( '.custom-scrollbar-collapsible-toggle-all-button-container' ).andSelf();
                    _oButtons.toggleClass( 'flipped' );
                    if ( _bForSections ) {
                        _oButton.parent().parent().children().children( '* > .custom-scrollbar-collapsible-title' ).each( function() {
                            jQuery( this ).trigger( 'click', [ 'by_toggle_all_button' ] );
                        } );
                    } else {
                        _oButton.closest( '.custom-scrollbar-sections' ).children( '.custom-scrollbar-section' ).children( '.custom-scrollbar-section-table' ).children( 'caption' ).children( '.custom-scrollbar-collapsible-title' ).each( function() {
                            jQuery( this ).trigger( 'click', [ 'by_toggle_all_button' ] );
                        } );
                    }
                    
                } );                
                             
            }); 
            
        } );      
        
    }
    /**
     * Binds the click event to collapsible buttons.
     */
    $.fn.enableCustomScrollbar_AdminPageFrameworkCollapsibleButton = function() {
        
        /**
         * Unbind the event first.
         * This is for widgets as the initial model widgets placed on the left side is dragged-and-dropped to a sidebar definition container.
         * Then the event binding will be lost so it needs to be rebound.
         */
        jQuery( this ).unbind( 'click' );   
        
        jQuery( this ).click( function( event, sContext ){
        
            // If a field element is clicked, do not collapse or expand the container box.
            var _sClickedTag = jQuery( event. target ).prop( 'tagName' ).toLowerCase();
            if ( -1 !== jQuery.inArray( _sClickedTag, [ 'input', 'span', 'label', 'fieldset' ] ) ) {
                return true;
            }
            
            // Expand or collapse this panel
            var _oThis = jQuery( this );
            var _sContainerType = jQuery( this ).hasClass( 'custom-scrollbar-collapsible-sections-title' )
                ? 'sections'
                : 'section';
            var _oTargetContent = 'sections' === _sContainerType
                ? jQuery( this ).next( '.custom-scrollbar-collapsible-content' ).first()
                : jQuery( this ).parent().siblings( 'tbody' );
            var _sAction = _oTargetContent.is( ':visible' ) ? 'collapse' : 'expand';

            _oThis.removeClass( 'collapsed' );
            _oTargetContent.slideToggle( 'fast', function(){

                // For Google Chrome, table-caption will animate smoothly for the 'section' containers (not 'sections' container). For FireFox, 'block' is required. For IE both works.
                var _bIsChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
                if ( 'expand' === _sAction && 'section' === _sContainerType && ! _bIsChrome ) {
                    _oTargetContent.css( 'display', 'block' );
                }
                
                // Update the class selector.
                if ( _oTargetContent.is( ':visible' ) ) {
                    _oThis.removeClass( 'collapsed' );
                } else {
                    _oThis.addClass( 'collapsed' );
                }            

            } );
            
            // If it is triggered from the toggle all button, do not continue.
            if ( 'by_toggle_all_button' === sContext ) {
                return;
            }

            // If collapse_others_on_expand argument is true, collapse others 
            if ( 'expand' === _sAction && _oThis.data( 'collapse_others_on_expand' ) ) {
                _oThis.parent().parent().children().children( '* > .custom-scrollbar-collapsible-content' ).not( _oTargetContent ).slideUp( 'fast', function() {
                    jQuery( this ).prev( '.custom-scrollbar-collapsible-title' ).addClass( 'collapsed' );
                });
            }

        });         
        
        
    }
}( jQuery ));
JAVASCRIPTS;
        
    }
    static private function _getToggleAllButtonHTML($oMsg) {
        $_sLabelToggleAll = $oMsg->get('toggle_all');
        $_sLabelToggleAllSections = $oMsg->get('toggle_all_collapsible_sections');
        $_sDashIconSort = self::getAOrB(version_compare($GLOBALS['wp_version'], '3.8', '<'), '', 'dashicons dashicons-sort');
        $_sText = self::getAOrB($_sDashIconSort, '', $_sLabelToggleAll);
        return "<div class='custom-scrollbar-collapsible-toggle-all-button-container'>" . "<span class='custom-scrollbar-collapsible-toggle-all-button button " . $_sDashIconSort . "'" . " title='" . esc_attr($_sLabelToggleAllSections) . "'>" . $_sText . "</span>" . "</div>";
    }
}
