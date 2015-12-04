<?php
class Adses extends PbModel {
 	var $name = "Ads";

 	function Ads()
 	{
		parent::__construct();
 	}
 	
 	function getCode($adv_params, $max_width, $max_height)
 	{
 		if ($adv_params['is_image']) {
 			return $this->getImageCode($adv_params, $max_width, $max_height);
 		}elseif ($adv_params['source_type']=="application/x-shockwave-flash"){
 			return $this->getFlashCode($adv_params, $max_width, $max_height);
 		}else{
 			return;
 		}
 	}
 	
 	function ife($condition, $val1 = null, $val2 = null) {
		if (!empty($condition)) {
			return $val1;
		}
		return $val2;
	}
 	
 	function getImageCode($adv_params, $max_width, $max_height)
 	{
 		$return = "<img border='0' ";
 		extract($adv_params); 		
 		if (empty($source_url)) {
 			return;
 		}
 		$return .= "src='{$source_url}' ";
 		if (!empty($width)) {
 			if($max_width>0){
 				$return.=$this->ife($width>$max_width, "width='{$max_width}' ", "width='{$width}' ");
 			}
 		}
 		if (!empty($height)) {
 			if($max_height>0){
 				$return.=$this->ife($height>$max_height, "height='{$max_height}' ", "height='{$height}' ");
 			}
 		}
 		$return .= !empty($title)?"alt='{$title}' ":null;
 		$return .= "/>";
 		return $return;
 	}
 	
 	function getFlvCode()
 	{
 		;
 	}
 	
 	function getFlashCode($adv_params, $max_width, $max_height)
 	{
 		extract($adv_params);
 		if (!empty($width)) {
 			if ($max_width>0) {
 				$width = $this->ife($width>$max_width, $max_width, $width);
 			}
 		}else{
 			if (!empty($max_width)) {
 				$width = $max_width;
 			}else{
 				$width = 100;
 			}
 		}
 		if (!empty($height)) {
 			if ($max_width>0) {
 				$height = $this->ife($height>$max_height, $max_height, $height);
 			}
 		}else{
 			if (!empty($max_height)) {
 				$height = $max_height;
 			}else{
	 			$height = 100;
	 		}
 		}
 		$id = empty($id)?pb_radom(3):"flash-".$id;
 		if (empty($source_url)) {
 			return 'This text is replaced by the Flash movie';
 		}
 		return '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" 
   codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" 
   width="'.$width.'" height="'.$height.'" id="'.$$id.'" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="'.$source_url.'" />
<param name="wmode" value="default" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<param name="base" value="'.URL.'" />
<embed src="'.$source_url.'" quality="high" bgcolor="#ffffff" width="'.$width.'" 
   height="'.$height.'" name="mymovie" align="middle" allowScriptAccess="sameDomain" 
   type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
</object>';
 	}
 	
 	function getBreathe($adzone_params)
 	{
 		$flash = 'images/breathe.swf';
 		$data_file = 'data/appcache/breathe-'.$adzone_params['id'].'.xml';
 		$width = (!empty($adzone_params['width']))?$adzone_params['width']:473;
 		$height = (!empty($adzone_params['height']))?$adzone_params['height']:170;
 		$code = '<object type="application/x-shockwave-flash" data="'.$flash.'" width="'.$width.'" height="'.$height.'" id="Breathe-'.$adzone_params['id'].'" bgColor="#ff0000">
				<param name="movie" value="'.$flash.'"/>
				<param name="allowFullScreen" value="true" />
				<param name="wmode" value="transparent" />
				<param name="FlashVars" value="xml='.$data_file.'" />
				<embed src="'.$flash.'" quality="high" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'"></embed>
		</object>';
 		return $code;
 	}
 	
 	function getFocus($params)
 	{
 		$focus_lists = array();
 		$width = 220;
 		$height = 160;
 		$flash_src = "images/focus.swf";
 		if (isset($params['target'])) {
 			$target = trim($params['target']);
 		}
 		if (isset($params['table'])) {
 			$target = trim($params['table']);
 		}
 		if (isset($params['from'])) {
 			$target = trim($params['from']);
 		}
 		switch ($target) {
 			case "fair":
 				$table = "expos";
 				$fields = "id,name AS title,picture,picture AS image";
 				$url = "index.php?do=fair&action=detail&id=";
 				break;
 			default:
 				$table = "newses";
 				$fields = "id,title,picture,picture AS image";
 				$url = "index.php?do=news&action=detail&id=";
 				break;
 		}
 		$sql = "SELECT ".$fields." FROM ".$this->table_prefix.$table." WHERE status='1' AND picture!='' ORDER BY id desc LIMIT 0,6";
 		$tmp_arr = $this->dbstuff->GetArray($sql);
 		if (!empty($tmp_arr)) {
 			foreach ($tmp_arr as $key=>$val) {
 				$focus_lists['pics'][] = pb_get_attachmenturl($val['picture']);
 				$focus_lists['links'][] = $url.$val['id'];
 				$focus_lists['texts'][] = pb_lang_split($val['title']);
 			}
 		}
 		$pics = implode("|", $focus_lists['pics']);
 		$links = implode("|", $focus_lists['links']);
 		$texts = implode("|", $focus_lists['texts']);
 		return "<script type=\"text/javascript\">
			var focus_width={$width};
			var focus_height={$height};
			var text_height=30;
			var swf_height = focus_height+text_height;
			var pics ='{$pics}';
			var links='{$links}';
			var texts='{$texts}';
			document.write('<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"'+ focus_width +'\" height=\"'+ swf_height +'\">');
			document.write('<param name=\"allowScriptAccess\" value=\"sameDomain\"><param name=\"movie\" value=\"{$flash_src}\"><param name=\"quality\" value=\"high\"><param name=\"bgcolor\" value=\"#F0F0F0\">');
			document.write('<param name=\"menu\" value=\"false\"><param name=wmode value=\"opaque\">');
			document.write('<param name=\"FlashVars\" value=\"pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'\">');
			document.write('<embed src=\"{$flash_src}\" wmode=\"opaque\" FlashVars=\"pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'\" menu=\"false\" bgcolor=\"#F0F0F0\" quality=\"high\" width=\"'+ focus_width +'\" height=\"'+ focus_height +'\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />');  
			document.write('</object>');
			</script>";
 	}
 	
 	/**
 	 * Image Switch.swf
 	 *
 	 * @param unknown_type $adzone_params
 	 * @return unknown
 	 */
 	function getImagePlay($adzone_params)
 	{
 		$titles = $imgs = $urls = array();
 		$id = "ID-".$adzone_params['created']."-".$adzone_params['id'];
 		$name = !empty($adzone_params['name'])?$adzone_params['name']:L("ads_no");
 		$return = "<div id='".$id."'>".$adzone_params['name']."</div>";
 		if (!empty($adzone_params['id'])) {
 			$ad_result = $this->dbstuff->GetArray($sql = "SELECT * FROM ".$this->table_prefix."adses WHERE adzone_id=".$adzone_params['id']." ORDER BY priority ASC,id DESC");
 			if (!empty($ad_result)) {
 				foreach ($ad_result as $key=>$val) {
 					$_ltitle = pb_lang_split($val['title']);
 					$titles[] = empty($_ltitle)?"No Title":$_ltitle;
 					$imgs[] = empty($val['source_url'])?"No Picture":$val['source_url'];
 					$urls[] = empty($val['target_url'])?URL:$val['target_url'];
 				}
 				$width = !empty($adzone_params['width'])?$adzone_params['width']:474;
 				$height = !empty($adzone_params['height'])?$adzone_params['height']:170;
 				$return.= "		
 		<script language='javascript' type='text/javascript'>
			var titles = '".implode("|", $titles)."';
			var imgs='".implode("|", $imgs)."';
			var urls='".implode("|", $urls)."';
			var pw = $width;
			var ph = $height;
			var sizes = 14;
			var Times = 4000;
			var umcolor = 0xFFFFFF;
			var btnbg =0xFF7E00;
			var txtcolor =0xFFFFFF;
			var txtoutcolor = 0x000000;
			var flash = new SWFObject('images/switch.swf', 'latestTargetId', pw, ph, '8', '');
			flash.addParam('allowFullScreen', 'true');
			flash.addParam('allowScriptAccess', 'always');
			flash.addParam('quality', 'high');
			flash.addParam('wmode', 'Transparent');
			flash.addVariable('pw', pw);
			flash.addVariable('ph', ph);
			flash.addVariable('sizes', sizes);
			flash.addVariable('umcolor', umcolor);
			flash.addVariable('btnbg', btnbg);
			flash.addVariable('txtcolor', txtcolor);
			flash.addVariable('txtoutcolor', txtoutcolor);
			flash.addVariable('urls', urls);
			flash.addVariable('Times', Times);
			flash.addVariable('titles', titles);
			flash.addVariable('imgs', imgs);
			flash.write('".$id."');
		</script>
";
 			}
 		}
 		return $return;
 	}
	
	function setPaid($id, $months, $amount)
	{
		//find parent's agent
		uses("adcheckout");
		$adcheckout = new Adcheckouts();
		
		$ad = $this->read("*", $id);
		
		//update transaction
		if($ad["status"] == 0 && $months != "" && $amount != "")
		{
			$adcheckout->save(array("ad_id" => $id, "created" => date("Y-m-d H:i:s"), "months" => $months, "amount" => $amount));
			
			$this->saveField("status", "1", intval($id));
		}
	}
	
	function getLastCheckout($ad_id)
	{
		uses("adcheckout");
		$transaction = new Adcheckouts();

		$lastcheck = $transaction->findAll("*", null, array("ad_id=".$ad_id), "created DESC", 0, 1);
		$lastcheck = $lastcheck[0];
		
		$lastcheck["created"] = date("Y-m-d", strtotime($lastcheck["created"]));
		if($lastcheck["months"]) {
			$lastcheck["deadline"] = date("Y-m-d", strtotime($lastcheck["created"])+(($lastcheck["months"]*30+15)*24*60*60));
			if(strtotime($lastcheck["deadline"]) - strtotime(date('Y-m-d')) <= 15*24*60*60)
			{
				$lastcheck["warning"] = true;
			}
		}

		return $lastcheck;
	}
	
	function formatResult($item) {		
		if (!empty($item['source_url'])) {
			if (strstr($item['source_url'], "http")) {
				$item['logo'] = $item['source_url'];
			}else{
				$item['logo'] = URL.$item['source_url'];
			}
		}
		else {
			if (empty($item['picture'])) {
				$item['logo'] = pb_get_attachmenturl('', '', 'small');
			}else{
				$item['logo'] = pb_get_attachmenturl($item['picture'], '', 'small');
			}
		}
		
		if(!empty($item['title'])) {
			$item["name"] = $item["title"];
		} else {			
			$item["name"] = $item["shop_name"];
		}
		if(!empty($item['target_url'])) {
			$item["href"] = $item["target_url"];		
		}
		else {
			$item["href"] = $this->url(array("module"=>"space", "userid"=>$item["cache_spacename"]));
		}
		
		$item["target_url"] = $this->url(array("module"=>"ad","id"=>$item["id"]));
		
		return $item;
	}
	
	function getByZone($zone_id, $order = "Ads.display_order", $limit=10, $industry_id) {
		uses("company");
		$company = new Companies();
		
		
		$joins = array("LEFT JOIN {$this->table_prefix}adsizes s ON s.id=Ads.adsize_id");
		$joins[] = "LEFT JOIN {$this->table_prefix}companies c ON c.id=Ads.company_id";
		
		$conditions = array("Ads.adzone_id=".$zone_id,"Ads.status=1","Ads.state=1");
		
		if($industry_id) {
			$conditions[] = "(Ads.industries LIKE '{$industry_id}' OR Ads.industries LIKE '{$industry_id},%' OR Ads.industries LIKE '%,{$industry_id},%' OR Ads.industries LIKE '%,{$industry_id}')";
		}
		
		$result = $this->findAll("c.shop_name,c.picture,c.name as com_name,s.name as size_name,s.width as size_width,s.height as size_height,Ads.*", $joins, $conditions, $order, 0, $limit);
		foreach($result as $key => $item) {
			$result[$key] = $this->formatResult($item);

			if($item["company_id"]) {
				$result[$key]["company"] = $company->getInfoById($item["company_id"]);
			}
		}
		
		return $result;
	}
	
	function getMobileHomeCats($zone_id=38) {
		uses("industry");
		$industry = new Industries();
		$industries = $industry->findAll("id, name", null, array("level = 1"), "display_order");
		foreach($industries as $key => $cat) {
			$joins = array("LEFT JOIN {$this->table_prefix}adsizes s ON s.id=Ads.adsize_id");
			$joins[] = "LEFT JOIN {$this->table_prefix}companies c ON c.id=Ads.company_id";
			
			$id = $cat["id"];
			
			$conditions = array("Ads.adzone_id=".$zone_id);
			$conditions[] = "(Ads.industries LIKE '{$id}' OR Ads.industries LIKE '{$id},%' OR Ads.industries LIKE '%,{$id},%' OR Ads.industries LIKE '%,{$id}')";
			//echo "(Ads.industries LIKE '{$id},%' OR Ads.industries LIKE '%,{$id},%' OR Ads.industries LIKE '%,{$id}')";
			
			$result = $this->findAll("c.shop_name,c.picture,s.name as size_name,s.width as size_width,s.height as size_height,Ads.*", $joins, $conditions, "Ads.display_order");
			foreach($result as $keys => $item) {
				$result[$keys] = $this->formatResult($item);
			}
			
			$industries[$key]["items"] = $result;
		}
		//var_dump($industries);
		return $industries;
	}
}
?>