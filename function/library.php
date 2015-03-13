<?php 
	function removeTitle($string, $keyReplace = "-", $keySearch = "/"){
	  $string = removeAccent($string);
	  $string =  trim(preg_replace("/[^A-Za-z0-9]/i"," ",$string)); // khong dau
	  $string =  str_replace(" ",$keyReplace,$string);
	  $string = str_replace($keyReplace . $keyReplace,$keyReplace,$string);
	  $string = str_replace($keyReplace . $keyReplace,$keyReplace,$string);
	  $string = str_replace($keyReplace . $keyReplace,$keyReplace,$string);
	  $string = str_replace($keyReplace . $keyReplace,$keyReplace,$string);
	  $string = str_replace($keyReplace . $keyReplace,$keyReplace,$string);
	  $string = str_replace($keyReplace . $keyReplace,$keyReplace,$string);
	  $string = str_replace($keySearch,$keyReplace,$string);
	  return strtolower($string);
	}				 

	function removeAccent($mystring){
	   $marTViet=array(
	      // Chữ thường
	      "à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
	      "è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
	      "ì","í","ị","ỉ","ĩ",
	      "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
	      "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
	      "ỳ","ý","ỵ","ỷ","ỹ",
	      "đ","Đ","'",
	      // Chữ hoa
	      "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
	      "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
	      "Ì","Í","Ị","Ỉ","Ĩ",
	      "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
	      "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
	      "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
	      "Đ","Đ","'"
	      );
	   $marKoDau=array(
	      /// Chữ thường
	      "a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a",
	      "e","e","e","e","e","e","e","e","e","e","e",
	      "i","i","i","i","i",
	      "o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
	      "u","u","u","u","u","u","u","u","u","u","u",
	      "y","y","y","y","y",
	      "d","D","",
	      //Chữ hoa
	      "A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A",
	      "E","E","E","E","E","E","E","E","E","E","E",
	      "I","I","I","I","I",
	      "O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
	      "U","U","U","U","U","U","U","U","U","U","U",
	      "Y","Y","Y","Y","Y",
	      "D","D","",
	      );
	   return str_replace($marTViet, $marKoDau, $mystring);
	}	

	function multimenu($data, $parent){
		echo '<div class="sublist"><ul>';
		foreach ($data as $value) {
			$string = removeTitle($value['title_name']);
			if($value['title_level'] == $parent){
				echo '<li><a href="/category/'.$string.'-'.$value['title_id'].'">'.$value['title_name'].'</a>';
				$id = $value['title_id'];
				multimenu($data, $id);
				echo '</li>';
			}
		}
		echo '</ul></div>';
	}

	// function list($table, $cat_id, $data = array()){
 //        $Title = new title();
 //        if(!$data)
 //        {
 //            $data = array();
 //        }
 //        $sql = "SELECT * FROM ".$table." WHERE title_level = ".$cat_id;
 //        $Title->query($sql);
 //        while($row = $Title->fetch()){
 //        	$data[] = array( 	'title_id' => $row['title_id'],
 //            				  	'title_name'=>$row['title_name']
 //                            );
 //        	$trees = list($table, $row['title_id'], $data);
 //        }
 //        return $data;
 //    }
	
	function Menu($parentid = 0, $space = "", $trees = array())
    {
        if(!$trees)
        {
            $trees = array();
        }
        $Title = new db_query("SELECT * FROM title WHERE title_level = $parentid");
        while($rs = mysql_fetch_assoc($Title->result))
        {
            $trees[] = array( 	'title_id' => $rs['title_id'],
            				  	'title_name'=>$space.$rs['title_name'],
                            );
            $trees = Menu($rs['title_id'], $space.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $trees);
        }
            return $trees;
    }

    function getChild($form, $cat_id){
    	$Title = new db_query("SELECT * FROM title WHERE title_level = ".$cat_id);
    	
		while($rows = mysql_fetch_assoc($Title->result)){
			$getChild = new db_query("SELECT * FROM post INNER JOIN title ON (post.title_id = title.title_id) WHERE post.title_id = ".$rows['title_id']." ORDER BY post_id DESC");
			while($row = mysql_fetch_array($getChild->result)){
				$string = removeTitle($row['post_name']);
				$string2 = removeTitle($row['title_name']);
				echo $form;
			}
			$cat_id = $rows['title_id'];
			getChild($form, $cat_id);
		}
    }
?>