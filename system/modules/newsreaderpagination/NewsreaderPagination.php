<?php
	class NewsreaderPagination extends \Frontend{ 
		 
		public function addPrevNext($newsID, $pid) {
			global $objPage;

			$result = \Database::getInstance()->prepare("SELECT id,alias FROM tl_news WHERE pid=? AND published=? ORDER BY time DESC, date DESC")->execute($pid, 1);  
			$idArray = array();
			$aliasArray = array();
			$index = 0;
			$prevAlias ="";
			$nextAlias = "";
			while($result->next()) {
				 array_push($idArray, $result->id);
				 array_push($aliasArray, $result->alias);
				 if($newsID == $result->id) {
				 	$aktIndex = $index;
				 }
				 $index++;
			}
			
			$numItems = count($idArray)-1;

			if($aktIndex != 0) {
				$prevAlias= $aliasArray[$aktIndex-1];
				if($aktIndex != $numItems) {
					$nextAlias = $aliasArray[$aktIndex+1];
				}
			} else {
				if($aktIndex != $numItems) {
					$nextAlias = $aliasArray[$aktIndex+1];
			    }
			}
			
			if($prevAlias != "") {
				$prevItemURL = $this->generateFrontendUrl($objPage->row(), ((isset($GLOBALS['TL_CONFIG']['useAutoItem']) && $GLOBALS['TL_CONFIG']['useAutoItem']) ?  '/' : '/items/') . $prevAlias);
				echo "<a id='prevItem' href='$prevItemURL'>".$GLOBALS['TL_LANG']['MSC']['previous']."</a>";
			}
			if($nextAlias != "") {
				$nextItemURL = "";
				$nextItemURL = $this->generateFrontendUrl($objPage->row(), ((isset($GLOBALS['TL_CONFIG']['useAutoItem']) && $GLOBALS['TL_CONFIG']['useAutoItem']) ?  '/' : '/items/') . $nextAlias);
				echo "<a id='nextItem' href='$nextItemURL'>".$GLOBALS['TL_LANG']['MSC']['next']."</a>";
			}
		}

	}

?>