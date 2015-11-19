<?
/*********************************************************************************************
* 
* Autor(es): Gelson S. Rodrigues
* Data da Criação: 08/11/2005
* Data da Atualização/Responsável: 08/11/2004 - Gelson
* Funcionalidade: Página de explicação de como usar as classes até agora criadas
* 
******************************************CABEÇALHO*******************************************/

class class_paginacao
{

		var $subtotal = ''; //recebe o valor 'subtotal' que e necessario para a criacao dos links usados na paginacao
		var $resto = ''; //recebe o valor 'resto' que e necessario para a criacao dos links usados na paginacao
		var $totalregistros = ''; //recebe o valor total dos registros encontrados no banco 
		var $registros = ''; // recebe o valor de quantos registros sao necessarios para a visualizacao
		var $pgcao = ''; // recebe o valor correspondente a pagina em que o usuario esta visualizando
		var $anterior =''; //recebe o valor 'anterior' que e necessario para a criacao dos links usados na paginacao 
		var $antde ='';//recebe o valor 'antde' que e necessario para a criacao dos links usados na paginacao
		var $de ='';//recebe o valor 'de' que e necessario para a criacao dos links usados na paginacao
		var $apartir ='';//recebe o valor 'apartir' que e necessario para a criacao dos links usados na paginacao
		var $link = '';//recebe o link que será usado para paginacao
		var $rotina = '';//recebe o valor 'rotina' para identificar mais alguma funcao da pagina
		var $corlinkativo = '#990000';//recebe a cor do link que ficara ativo		
		var $coditem = '';//recebe o valor 'coditem' que pode ser usado para guardar outros parametros da pagina
		var $coditem2 = '';//recebe o valor 'coditem2' que pode ser usado para guardar outros parametros da pagina
		var $prox = '';
		
        function class_paginacao()
        {

						
						$this->subtotal = ($this->totalregistros / $this->registros);
						$this->resto	=	strpos($this->subtotal,".",0);
						$this->resto	=	substr($this->subtotal,$this->resto+1,2);
						
						if ($this->resto > "0")
                        {
							$this->subtotal = $this->subtotal + 1;
						}
						// utilizo o round para arredondar o valor para inteiro ficando 2 ou 4
						$this->subtotal = round($this->subtotal);

                        // a variável página recebe 1
						if ($this->pgcao == "")
                        {
						  $this->pgcao = 1;
						}

                        if ($this->registros < $this->totalregistros)
                        {
							if ($this->anterior >= 1)
                            {
							   $this->antde = $this->pgcao - 1;
							   echo "<a class='link' href='".$this->link."?prox=".$this->anterior."&pgcao=".$this->antde."&btrotina=".$this->rotina."'>anterior</a>  ";
							}

							while ($this->de <= $this->subtotal)
                            {
								if ($this->coditem != "")
                                {
								   if($this->apartir <= $this->totalregistros)
                                   {
										if ($this->pgcao == $this->de)
                                        {
											echo " <font color=".$this->corlinkativo."> [ ".$this->de." ] </font>";
										}
                                        else
                                        {
											echo "<a class='link' href='".$this->link."?prox=".$this->apartir."&pgcao=".$this->de."&btrotina=".$this->rotina."'> -".$this->de."- </a> ";
										}
								    }
								 }
													
									$this->apartir = $this->apartir + $this->registros;
									$this->de = $this->de + 1;
												
							}
														

							if ($this->coditem2 != "")
                            {
								$this->de = $this->pgcao + 1;
								echo "<a class='link' href='".$this->link."?prox=".$this->prox."&pgcao=".$this->de."&btrotina=".$this->rotina."'>próxima</a>";
							}
						}


        } // fim da função  -> class_paginacao
}
?>
