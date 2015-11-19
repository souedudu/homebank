<?
//include("../Connections/Banco.php");

function Conn()
{
		$c = mysql_connect("localhost", "root", "") or die(mysql_error()); 
		mysql_select_db("homebank", $c);

		return $c;

}

function montaMenu($id=0)
{
//	if($id==0) $tmp = " and popup=1"; else $tmp = "";
	
	$Conexao = Conn();
     if($Conexao)
     {

      $sql = "Select distinct m.codpaimenu from menu m, acessousu a, usuario u
             where u.codusuario = a.codusuario and m.codpaimenu =".$id."
             and m.codmenu = a.codmenu and u.codusuario = ".$_SESSION['codusuarioadm'];
	  $rs = mysql_query($sql, $Conexao)or die(mysql_error());
	  $rs1 = mysql_fetch_array($rs);
	  $menu = "";
	  
	  if (($rs1 == 0))
  	    return $menu;
	  
	  $i = 0;
//	  while($a = mysql_fetch_array($rs))
	   while (!($rs1 == 0))
	  {
        $x = pegaItens($rs1['codpaimenu']);
		$menu .= $x[1];
		$menu .= 'window.menu_'.$rs1['codpaimenu'].' = new Menu("root",220,14,"Verdana, Arial, Helvetica, sans-serif",9,"#003333","#FFFFFF","#F2F2F2","#79A289","left","middle",2,0,1000,-5,7,true,true,true,0,true,true);'.chr(10);
		$menu .= $x[0];
		$menu .= 'menu_'.$rs1['codpaimenu'].".hideOnMouseOut=true;".chr(10);
		$menu .= 'menu_'.$rs1['codpaimenu'].".bgColor='#669999';".chr(10);
		$menu .= 'menu_'.$rs1['codpaimenu'].".menuBorder=1;".chr(10);
		$menu .= 'menu_'.$rs1['codpaimenu'].".menuLiteBgColor='#669999';".chr(10);
		$menu .= 'menu_'.$rs1['codpaimenu'].".menuBorderBgColor='#C4D7CD';".chr(10);
		$i = $rs1['codpaimenu'];
		$rs1 = mysql_fetch_array($rs);
	}
	//$menu .= 'menu_'.$i.".writeMenus();";

    }
	else
		$menu = "<script> alert('Erro ao conectar-se ao Banco de Dados!')</script>";

	return $menu;
}

function pegaItens($id)
{
	$Conexao = Conn();

	$sql = "Select m.* from menu m, acessousu a 
             where m.codpaimenu = $id and
                   m.codmenu = a.codmenu and a.codusuario = ".$_SESSION['codusuarioadm']." order by m.desmenu asc";
			 			 
	$rs = mysql_query($sql, $Conexao) or die(mysql_error());
	$menu = "";
	while($a = mysql_fetch_array($rs))
	{
		if($a['desmenu'] != "")
		{
			$menu .= 'menu_'.$id.'.addMenuItem("'.$a['desmenu'].'","location=\''.$a['desurl'].'\'");'.chr(10);
		}
	}

	return array($menu);
	
	//return $menu.chr(10);
}

function menu_popup()
{
	$x = montaMenu(1);
	$y = montaMenu(2);
	
  if ($x != "")
  {
	$texto = '<script> function mmLoadMenus(){'.chr(10);
	$texto .= $x.chr(10);
	 $i = 1;
  }

  if ($y != "")
  {
     $texto .= chr(10).$y;
	 $i = 2;
  }
  
  if ($x != "")
  {  
    $texto .= 'menu_'.$i.".writeMenus();";
	$texto .= '}'.chr(10);
	
//	$texto .= 'mmLoadMenus();'.chr(10).'
	$texto .= '			  </script>';
   }

	return $texto;
}

echo menu_popup();

Conexao($opcao='close');

?>
