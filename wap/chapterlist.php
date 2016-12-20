<?php 
	require 'main.php';
	require '17mb/class/sql.php';
	require($_17mb_pcdir."/configs/article/sort.php");
	$url=$_SERVER['REQUEST_URI'];	

	if($_GET['aid'] && $_GET['page']){
		$aid = intval($_GET['aid']);
		$pageid = intval($_GET['page']);
		
		if($_GET[desc]){
			$desc = intval($_GET[desc]);
			if(is_int($desc)){
				$desc = "desc";
			}	
		}
		else{
			$desc = "";	
		}
		
		$pagecount = 1 ;//����ҳ
		$pagenum = 20 ;//ÿҳ�ж���������
		
		$numall = 1;//ȫ����������
		$numbegin = 1;//��ʼ����
		$numend = 1;//��������
		
		$previd = 1;//��һҳҳ��
		$nextid = 1;//��һҳҳ��
		
		$numall =  $db->get_var("select count(chapterid) from ".$_17mb_prev."article_chapter where chaptertype = '0' and articleid = '".$aid."' ");
		$pagecount = ceil( $numall / $pagenum ) ;
		
		$numbegin = ( $pageid - 1 ) * $pagenum ;
		$numend = $pagenum ;
		
		$article = $db->get_row("select articleid,articlename,sortid,author from ".$_17mb_prev."article_article where articleid = '".$aid."' ");
		$shortid = intval($aid/1000);
		$tpl->assign('articleid',$aid);
		$tpl->assign('articlename',$article->articlename);
		$tpl->assign('author',$article->author);
		$tpl->assign('sortname',$jieqiSort['article'][$article->sortid]['caption']);
		$tpl->assign("desc",$desc);
		$tpl->assign("shortid",$shortid);
		
		//������һҳ����һҳҳ��
		if($pageid != 1){
			$previd = $pageid - 1;
		}
		if($pageid != $pagecount){
			$nextid = $pageid + 1;
		}
		else{
			$nextid = $pagecount;
		}
				
		$chapter = $db->get_results("select chapterid,chaptername from ".$_17mb_prev."article_chapter where chaptertype = '0' and articleid = '".$aid."' order by chapterorder ".$desc." limit ".$numbegin.",".$numend." ");	
		if($chapter){
			$k = 0;
			foreach($chapter as $v){
				$arr[$k][chapterid] = $v->chapterid;
				$arr[$k][chaptername] = $v->chaptername;
				$k++;
			}
			$tpl->assign('chapter',$arr);

			if(!$desc){
				//ҳ������//����
				$shouye = '<a href="/'.$shortid.'/'.$aid.'_1/">��ҳ</a>';
				$prepage = '<a href="/'.$shortid.'/'.$aid.'_'.$previd.'/">��һҳ</a>';
				$nextpage = '<a href="/'.$shortid.'/'.$aid.'_'.$nextid.'/">��һҳ</a>';
				$weiye = '<a href="/'.$shortid.'/'.$aid.'_'.$pagecount.'/">βҳ</a>';
				//��ҳβҳ����
				//��һҳ
				if($pageid == 1 ){ $shouye = '';$prepage = ''; }
				//���һҳ
				if($pageid == $pagecount){ $weiye = '';$nextpage = ''; }
				if($pageid == 1 && $pageid == $pagecount){
					$nextpage = '<a href="/'.$shortid.'/'.$aid.'_'.$nextid.'/">��һҳ</a>';
					$weiye = '<a href="/'.$shortid.'/'.$aid.'_'.$pagecount.'/">βҳ</a>';	
				}
			}
			else{
				//ҳ������//����
				$shouye = '<a href="/'.$shortid.'/'.$aid.'_1_1/">��ҳ</a>';
				$prepage = '<a href="/'.$shortid.'/'.$aid.'_'.$previd.'_1/">��һҳ</a>';
				$nextpage = '<a href="/'.$shortid.'/'.$aid.'_'.$nextid.'_1/">��һҳ</a>';
				$weiye = '<a href="/'.$shortid.'/'.$aid.'_'.$pagecount.'_1/">βҳ</a>';
				//��ҳβҳ����
				//��һҳ
				if($pageid == 1 ){ $shouye = '';$prepage = ''; }
				//���һҳ
				if($pageid == $pagecount){ $weiye = '';$nextpage = ''; }
				if($pageid == 1 && $pageid == $pagecount){
					$nextpage = '<a href="/'.$shortid.'/'.$aid.'_'.$nextid.'_1/">��һҳ</a>';
					$weiye = '<a href="/'.$shortid.'/'.$aid.'_'.$pagecount.'_1/">βҳ</a>';	
				}
			}
			
			$pagecontent = '
			<div class="page">'.$shouye.$prepage.$nextpage.$weiye.'</div>
			<div class="page">����ҳ��<input id="pageinput" size="4" /><input type="button" value="��ת" onclick = "page()" /> <br/>(��'.$pageid.'/'.$pagecount.'ҳ)��ǰ'.$pagenum.'��/ҳ</div>';
			$tpl->assign("jumppage",$pagecontent);
		}
		else{
			
		}
		
	}
	$cachedir = str_replace('\\','/',$tpl->cache_dir).intval($aid/1000)."/".$aid;
	$tpl->cache_dir = $cachedir;
	$tpl->display('chapterlist.html',$url);
?>