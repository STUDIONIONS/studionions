<?php
namespace Studionions;

class Plugins {
	
	protected $modx = null;
	
	public function __construct(\DocumentParser $modx)
	{
		$this->modx = &$modx;
	}
	
	public function snippets()
	{
		$this->modx->addSnippet('OgImage','$imageOg = $modx->documentObject[\'ogimage\'][1];$output = "";if(is_file(MODX_BASE_PATH.$imageOg)){$one_input = $modx->runSnippet(\'phpthumb\', array(\'input\'=>$imageOg,\'options\'=>\'w=537,h=240,zc=C,bg=ffffff,f=jpeg\'));$two_input = $modx->runSnippet(\'phpthumb\', array(\'input\'=>$imageOg,\'options\'=>\'w=400,h=400,zc=C,bg=ffffff,f=jpeg\'));$one_input_size = getimagesize(MODX_BASE_PATH.$one_input);$two_input_size = getimagesize(MODX_BASE_PATH.$two_input);$output = "<meta property=\"og:image\" content=\"[(site_url)]".$one_input."\" />\n";if($one_input_size){$output .= "	<meta property=\"og:image:width\" content=\"".$one_input_size[0]."\" />\n";$output .= "	<meta property=\"og:image:height\" content=\"".$one_input_size[1]."\" />\n";$output .= "	<meta property=\"og:image:type\" content=\"".$one_input_size[\'mime\']."\" />\n";}$output .= "	<meta property=\"og:image\" content=\"[(site_url)]".$two_input."\" />\n";if($one_input_size){$output .= "	<meta property=\"og:image:width\" content=\"".$two_input_size[0]."\" />\n";$output .= "	<meta property=\"og:image:height\" content=\"".$two_input_size[1]."\" />\n";$output .= "	<meta property=\"og:image:type\" content=\"".$two_input_size[\'mime\']."\" />\n";}}return $output;');
		$this->modx->addSnippet('GetFileTime', '$path = isset($input) ? $input : ""; $path = Studionions\Plugins::getFileTime($path); return $path;');
		$this->modx->addSnippet('GetFileContent', '$input = isset($input) ? $input : "";$type = isset($type) ? $type : "html";return Studionions\Plugins::getFileContent($input, $type);');
		$this->modx->addSnippet('GetDocAlias', '$id = isset($id) ? $id : $modx->documentIdentifier;$doc = $modx->getDocument($id, "alias"); return $doc["alias"];');
		$this->modx->addSnippet('GetTabsBrands', 'return Studionions\Plugins::getBrandsValues();');
	}
	
	public function run()
	{
		switch($this->modx->Event->name)
		{
			case "OnWebPageInit":
			case "OnPageNotFound":
			case "OnPageUnauthorized":
				$this->snippets();
				break;
			case "OnWebPagePrerender":
				if($this->modx->documentObject['minify'][1]==1){
					$str = $this->modx->documentOutput;
					$re = '/((?:content=)|(?:"description":\s+))(?:"|\')([A-я\S\s\d\D\X\W\w]+)?(?:"|\')/mUui';
					$str = preg_replace_callback($re, array(
							$this,
							'replaceHtml'
						), $str
					);
					$str = preg_replace(
						"/(\xD6\xD6\xD6\xD6)/", "\n", preg_replace(
							'|\s+|', ' ', preg_replace(
								'|(\s+)?\n(\s+)?|', '', preg_replace(
									'|<!(--)?(\s+)?(?!\[).*-->|', '', $str
								)
							)
						)
					);
					$this->modx->documentOutput = $str;
				}
				break;
			case "OnSiteSettingsRender":
				$str = "<h2>STUDIONIONS</h2>";
				$this->modx->Event->output($str);
				break;
			default:
				break;
		}
	}
	
	public static function getFileTime($path)
	{
		$file = "/".trim(trim($path),"\t .&?\\/");
		return is_file(MODX_BASE_PATH.$file) ? $path."?".filemtime(MODX_BASE_PATH.$file) : $path."?".time();;
	}
	
	public static function getFileContent($path, $type="html")
	{
		$return = "";
		$file = "/".trim(trim($path),"\t .&?\\/");
		if(is_file(MODX_BASE_PATH.$file)){
			$return = file_get_contents(MODX_BASE_PATH.$file);
			switch($type){
				case "js":
					$return = "<script>\n".$return."\n</script>";
					break;
				case "css":
					$return = "<style>\n".$return."\n</style>";
					break;
				default:
					break;
			}
		}
		return $return;
	}
	
	public static function getBrandsValues()
	{
		global $modx;
		$tbl_tmplvars = $modx->getFullTableName('site_tmplvars');
		$sql = "SELECT * FROM {$tbl_tmplvars} WHERE name = 'project_type';";
		$res = $modx->db->query($sql);
		$return = array();
		if($modx->db->getRecordCount($res)==1):
			$row = $modx->db->getRow($res);
			$arrElements = explode("||", $row['elements']);
			foreach($arrElements as $key=>$value):
				$arrVallue = explode("==", $value);
				$return[] = array(
					"title" => $arrVallue[0],
					"filter" => trim($arrVallue[1],",")
				);
			endforeach;
		endif;
		$output = '<div class="tabs-wrapper"><ul class="tabs-menu mixtab clearfix"><li class="link_transform col-xs-3 active"><a href="javascript:;" data-filter="all" class="tabs-link link_transform"><span class="tabs-link-text">Все</span></a></li>';
		foreach($return as $filter_key => $filter_value):
			$output .= '<li class="link_transform col-xs-3"><a href="javascript:;" data-filter="'.$filter_value['filter'].'" class="tabs-link"><span class="tabs-link-text">'.$filter_value['title'].'</span></a></li>';
        endforeach;
		$output .= '</ul><div class="tabs-button"><div class="button"></div></div></div>';
		return $output;
	}
	
	private function replaceHtml($matches)
	{
		$res = preg_replace('(\r(?:\n)?)', "\xD6\xD6\xD6\xD6", $matches[2]);
		return $matches[1].'"'.$res.'"';
	}
	
	private function onSiteSettingsRender()
	{
		$settings = array(
			array(
				"label" => "",
				"name" => "",
				"description" => "",
				"type" => "text"
			),
			array(
				"label" => "",
				"name" => "",
				"description" => "",
				"type" => "textarea"
			)
		);
		$str = '<table>';
		
		$str .= '</table>';
		return $str;
	}
	
}