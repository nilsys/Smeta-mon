<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2016 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('Restricted access');

JHtml::_('jquery.framework');
JHtml::_('jquery.ui', array('core', 'sortable'));
JHtml::_('formbehavior.chosen', 'select');

require_once JPATH_COMPONENT_ADMINISTRATOR .'/builder/classes/base.php';
require_once JPATH_COMPONENT_ADMINISTRATOR .'/builder/classes/config.php';

$doc = JFactory::getDocument();
$app = JFactory::getApplication();
$params = JComponentHelper::getParams('com_sppagebuilder');

$doc->addStylesheet( JURI::base(true) . '/administrator/components/com_sppagebuilder/assets/css/pbfont.css' );
$doc->addStyleSheet(JUri::base(true).'/components/com_sppagebuilder/assets/css/font-awesome.min.css');
$doc->addStyleSheet(JUri::base(true).'/components/com_sppagebuilder/assets/css/animate.min.css');
$doc->addStyleSheet(JUri::base(true).'/components/com_sppagebuilder/assets/css/sppagebuilder.css');
$doc->addStyleSheet(JUri::base(true).'/components/com_sppagebuilder/assets/css/medium-editor.min.css');
$doc->addStyleSheet(JUri::base(true).'/components/com_sppagebuilder/assets/css/medium-editor-beagle.min.css');
$doc->addStyleSheet(JUri::base(true).'/components/com_sppagebuilder/assets/css/edit-iframe.css');
if ($params->get('addcontainer', 1)) {
	$doc->addStyleSheet(JUri::base(true) . '/components/com_sppagebuilder/assets/css/sppagecontainer.css');
}

$doc->addScriptdeclaration('var pagebuilder_base="' . JURI::root() . '";');
$doc->addScript( JUri::base(true). '/components/com_sppagebuilder/assets/js/medium-editor.min.js' );
$doc->addScript( JURI::base(true) . '/administrator/components/com_sppagebuilder/assets/js/script.js' );
$doc->addScript( JUri::base(true). '/components/com_sppagebuilder/assets/js/actions.js' );
$doc->addScript( JURI::base(true) . '/components/com_sppagebuilder/assets/js/jquery.parallax.js' );
$doc->addScript( JURI::base(true) . '/components/com_sppagebuilder/assets/js/sppagebuilder.js' );

$menus = $app->getMenu();
$menu = $menus->getActive();
$menuClassPrefix = '';
$showPageHeading = 0;

// check active menu item
if ($menu) {
	$menuClassPrefix 	= $menu->params->get('pageclass_sfx');
	$showPageHeading 	= $menu->params->get('show_page_heading');
	$menuheading 		= $menu->params->get('page_heading');
}

require_once JPATH_COMPONENT_ADMINISTRATOR . '/builder/classes/addon.php';
$this->item->text = SpPageBuilderAddonHelper::__($this->item->text, true);
//$this->item->text = SpPageBuilderAddonHelper::getFontendEditingPage($this->item->text);

SpPgaeBuilderBase::loadAddons();
$addons_list = SpAddonsConfig::$addons;

foreach ($addons_list as &$addon) {
	$addon['visibility'] = true;
	unset($addon['attr']);
}
SpPgaeBuilderBase::loadAssets($addons_list);
$addon_cats = SpPgaeBuilderBase::getAddonCategories($addons_list);
$doc->addScriptdeclaration('var addonsJSON=' . json_encode($addons_list) . ';');
$doc->addScriptdeclaration('var addonCats=' . json_encode($addon_cats) . ';');

if (!$this->item->text) {
	$doc->addScriptdeclaration('var initialState=[];');
} else {
	$doc->addScriptdeclaration('var initialState=' . $this->item->text . ';');
}
?>

<div id="sp-page-builder" class="sp-pagebuilder <?php echo $menuClassPrefix; ?> page-<?php echo $this->item->id; ?>">
	<div id="sp-pagebuilder-container">
		<div class="sp-pagebuilder-loading-wrapper">
			<div class="sp-pagebuilder-loading">
				<i class="pbfont pbfont-pagebuilder"></i>
			</div>
		</div>
	</div>
</div>
<style id="sp-pagebuilder-css" type="text/css">
	<?php echo $this->item->css; ?>
</style>
<script type="text/javascript">
	jQuery(document).on('click', 'a', function(e){
		e.preventDefault();
	})

	jQuery(document).on('click', '.sp-editable-content', function(e){
		e.preventDefault();
		var ids = jQuery(this).attr('id')
		
		var editor = new MediumEditor('#'+ids,{
			toolbar: {
				allowMultiParagraphSelection: true,
				buttons: [
					'bold', 'italic', 'underline',
					{
						name: 'anchor',
						contentDefault: '<i class="fa fa-link"></i>',
						anchorPreview: false,
						formSaveLabel: '<i class="fa fa-check"></i>',
						formCloseLabel: '<i class="fa fa-times"></i>'
					},'h2','h3',
					{
						name: 'unorderedlist',
						contentDefault: '<i class="fa fa-list-ul"></i>'
					},
					{
						name: 'orderedlist',
						contentDefault: '<i class="fa fa-list-ol"></i>'
					}
					],
				diffLeft: 0,
				diffTop: -10,
				firstButtonClass: 'medium-editor-button-first',
				lastButtonClass: 'medium-editor-button-last',
				relativeContainer: null,
				standardizeSelectionStart: false,
				static: false,
				align: 'center',
				sticky: false,
				updateOnEmptySelection: false,
			}
		});
	})
	
</script>
