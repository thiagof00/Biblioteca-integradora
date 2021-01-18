<!-- ARQUIVO QUE FAZ A EMISSÃO, SERVIÇOS E TODAS AS TABELAS DO SISTEMA -->
<?php
function tabela($tabela,$dados,$coluna,$codigo,$paginas){
    include("../conecta.php");
    $i=1;  
            if($coluna == "nomel" or $coluna == "autor"){
                $sql = "SELECT * FROM $tabela WHERE $coluna LIKE \"$codigo\"";
                $resultado = mysqli_query($conexao, $sql);
            }

            if($coluna=="*"){
             // Prepara o SQL e Consulta no banco
              $sql = "SELECT $coluna FROM $tabela ";
             $resultado = mysqli_query($conexao, $sql);
            }
            
            if($coluna != "*" and $coluna != "nomel" and $coluna != "autor"){
                // Prepara o SQL e Consulta no banco
                $sql = "SELECT * FROM $tabela WHERE $coluna = \"$codigo\"";
               $resultado = mysqli_query($conexao, $sql); 
            }
            
            $colunas = mysqli_num_fields($resultado)-1;
            //paginação
                $total = mysqli_num_rows($resultado);
                $registros = 15;
                $numPaginas = ceil($total/$registros);
                $inicio = ($registros*$paginas)-$registros;
                if($coluna == "nomel" or $coluna == "autor"){
                    $sql = "SELECT * FROM $tabela WHERE $coluna LIKE \"$codigo\" LIMIT $inicio,$registros";
                    $resultado = mysqli_query($conexao, $sql);
                    
                }

                if($coluna=="*"){
                // Prepara o SQL e Consulta no banco
                $sql = "SELECT $coluna FROM $tabela LIMIT $inicio,$registros";
                $resultado = mysqli_query($conexao, $sql);
                }
                
    
             //caso reserva
            $specialCase=$dados[0];
            $especifico=$dados[1];
            if($especifico=="t"){$i++;$colunas--;}
            if($specialCase=="r" or $specialCase=="s"){$i++;$colunas++;}
            if($specialCase=="s" and $dados[2]=="Retirada"){$i++;}
            if($specialCase == "h"){$i++;}
             // Mostra os campos da tabela
            echo '<div id="dados"><table>';
            echo '<tr>'; 
             while ($i <= $colunas+1){ 
                echo('<th> '.$dados[$i].' </th>');
                 $i++;}
            echo '</tr></div>';
             //puxando do banco os dados
            if($specialCase=="r"){
                //select
                if(@$coluna=="id_leitores"){
                    while($a=$resultado->fetch_assoc())
                    {  
                    $L=$a["id_livros"];
                    $Le=$a["id_leitores"];
                    $sql = "SELECT nomel FROM livros where id=\"$L\"";
                    $nomel = mysqli_query($conexao, $sql);
                    $sql = "SELECT nome,cpf FROM leitores where id=\"$Le\"";
                    $nome = mysqli_query($conexao, $sql);
                    $nomeLeitores = $nome -> fetch_assoc();
                    $nomeLivros = $nomel -> fetch_assoc();
                    $d[0]=$a['id'];
                    $d[1]=$a['datasr'];
                    $d[2]=$a['dataret'];
                    $d[3]=$nomeLeitores['nome'];
                    $d[4]=$nomeLivros['nomel'];
                    $cpf=$d[3]=$nomeLeitores['cpf'];
                        $j=1;
                    echo '<tr>';
                    while($j < $colunas)
                    {
                        echo '<td> <a id=reservelink href=select.php?codigo='.$cpf.'&coluna=cpf&tabela=leitores&dados=s,t,id,RG,Nome,cpf,Telefone,Endereço>'.$d[$j].'</td>';
                        $j++; 
                    }
                    echo '<td> <div class="options"><a href="../usuarios/alterar.php?id='.$d[0].'">'
                                . '<img src="../styles/img/gear.svg" alt="Editar">'
                                . '</a> ';         
                        echo ' <a href="excluir.php?id='.$d[0].'&tabela='.$tabela.'">'
                                . '<img src="../styles/img/delet.svg" alt="Excluir">'
                                . '</a> </div></td>';
                    echo '</tr></div>';
                }   
                }
                //index
                else{
                    $sql = "SELECT * FROM livros";
                    $nomel = mysqli_query($conexao, $sql);
                    $sql = "SELECT * FROM leitores";
                    $nome = mysqli_query($conexao, $sql);
                }
                //listagem de dados da reserva
                if($specialCase=="r" and $coluna!="id_leitores"){

                    //safe
                    $sF=0;
                    //os sacanas
                    $oS=0;
                    //os avisados
                    $oA=0;
                    $quantidade= mysqli_num_rows($resultado);
                    $count = 0;
                    while($dados = $resultado->fetch_assoc()){
                        $id = $dados['id'];
                        $id_livros = $dados['id_livros'];
                        $id_leitores = $dados['id_leitores'];
                        $dTable[$count][0]=$id;
                        $dTable[$count][1]=$dados['dataret'];
                        $dTable[$count][2]=$dados['datasr'];
                        
                        $sql = "SELECT nome FROM leitores WHERE id = \"$id_leitores\"";
                        $nome = mysqli_query($conexao, $sql);
                        $nomeLeitores = $nome -> fetch_assoc();
                        $dTable[$count][3]=$nomeLeitores['nome'];

                        $sql = "SELECT nomel FROM livros WHERE id = \"$id_livros\"";
                        $nomel = mysqli_query($conexao, $sql);
                        $nomeLivros = $nomel -> fetch_assoc();
                        $dTable[$count][4]=$nomeLivros['nomel'];
                        $dTable[$count][5]=$id_livros;
                      
                        $count++;
                        
                    }
                    $count = 0;
                    while ($count < $quantidade)
                    {
                        
                        //Pega a data do dia ATUAL
                        date_default_timezone_set('America/Sao_Paulo');
                        $datahj=explode("/",date('d/m/y'));                                           
                       $dataentr=explode("/",$dTable[$count][2]);
                        $SM = $dataentr[0];
                        $SH = $datahj[0];
                        
                        //teste de atraso

                        //$DD diferença dia
                        $DD = $SH - $SM;
                        $d = $dTable[$count];
                          
                        //$DM diferença mês
                        $DM = $dataentr[1]-$datahj[1];
                        //caso ano for igual                        
                        if($datahj[2] == $dataentr[2]){
                        //calcular a diferença dos dias
                            //caso mes for igual
                            if($datahj[1] == $dataentr[1]){
                                if($DD <= 0 ){
                                    $oSafes[] = $d;
                                    $sF++;
                                }
                                //caso dia for maior ou igual a 1 e menor que 3
                                if($DD >= 1 and $DD <= 3 ){
                                    $osAvisados[] = $d;
                                    $oA++;
                                }
                                if($DD >= 4 ){
                                    $oSacanas[] = $d;
                                    $oS++;
                               }                                
                            }//meses diferentes
                            else{
                                if($datahj[1] < $dataentr[1]){
                                    $oSafes[] = $d;
                                    $sF++;
                                }
                                if($datahj[1] > $dataentr[1] and $datahj[0] < $dataentr[0]){
                                    if($datahj[0]==1){
                                        switch ($datahj[1]) { 
                                            case 03:
                                                if($DD<=-25 and $DD>=-28){
                                                    $osAvisados[] = $d;
                                                    $oA++;
                                                }
                                                else{
                                                    $oSacanas[] = $d;
                                                    $oS++;
                                                } 
                                                break; 
                                            case 05:
                                            case 07:
                                            case 10:
                                            case 12:
                                                if($DD<=-27 and $DD>=-29){
                                                    $osAvisados[] = $d;
                                                    $oA++;
                                                }
                                                else{
                                                    $oSacanas[] = $d;
                                                    $oS++;
                                                } 
                                                break; 
                                            default:
                                                if($DD<=-28 and $DD>=-30){
                                                    $osAvisados[] = $d;
                                                    $oA++;
                                                }
                                                else{
                                                    $oSacanas[] = $d;
                                                    $oS++;
                                                } 
                                                break;
                                            }
                                        }
                                    if($datahj[0]==2){
                                        switch ($datahj[1]) { 
                                            case 03:
                                                if($DD ==-25 or $DD ==-27){
                                                    $osAvisados[] = $d;
                                                    $oA++;
                                                }
                                                else{
                                                    $oSacanas[] = $d;
                                                    $oS++;
                                                } 
                                                break; 
                                            case 05:
                                            case 07:
                                            case 10:
                                            case 12:
                                                if($DD == -27 or $DD ==-28){
                                                    $osAvisados[] = $d;
                                                    $oA++;
                                                }
                                                else{
                                                    $oSacanas[] = $d;
                                                    $oS++;
                                                } 
                                                break; 
                                            default:
                                                if($DD == -28 or $DD == -29){
                                                    $osAvisados[] = $d;
                                                    $oA++;
                                                }
                                                else{
                                                    $oSacanas[] = $d;
                                                    $oS++;
                                                } 
                                                break;
                                        }
                                        }
                                        if($datahj[0]>=3){
                                            $oSacanas[] = $d;
                                            $oS++;   
                                        } 
                                    }
                                    if($datahj[1] > $dataentr[1] and $datahj[0] > $dataentr[0]){
                                        $oSacanas[] = $d;
                                        $oS++;
                                    } 
                                
                            }                                  
                        }
                        //Anos diferentes
                        if($datahj[2] != $dataentr[2]){
                            if($DM==11 or $DM<0){
                                if($datahj[1] == $dataentr[1]){
                                    if($DD <= 0 ){
                                        $oSafes[] = $d; 
                                        $sF++;
                                    }
                                    if($DD >= 1 and $DD <= 3 ){
                                        $osAvisados[] = $d;
                                        $oA++;
                                    }
                                    if($DD >= 4 ){
                                        $oSacanas[] = $d;
                                        $oS++;
                                   }                        
                                }
                            }
                            else{
                                $oSacanas[] = $d;
                                $oS++;}
                        }  
                        $count++;        
                    }
                    //parte vermelha
                    for ($i=0; $i < $oS; $i++) { 
                            $j=1;
                        echo '<tr>';
                        while($j < $colunas)
                        {
                            echo '<td id=oSacanas>'.$oSacanas[$i][$j].'</td>';
                            $j++; 
                        }
                        echo '<td> <div class="options"><a href="alterar.php?id='.$oSacanas[$i][0].'">'
                                    . '<img src="../styles/img/gear.svg" alt="Editar">'
                                    . '</a> ';         
                        echo '<script>
                                    function showmodal'.$oSacanas[$i][0].'(){
                                        var modal= document.querySelector("#modal'.$oSacanas[$i][0].'")    
                                        modal.style.display= "block"
                        
                                    }
                                    function closeModal'.$oSacanas[$i][0].'(){
                                        var btnClose = document.querySelector("#cancel")
                                        var modal= document.querySelector("#modal'.$oSacanas[$i][0].'")
                                        
                                        modal.style.display= "none"             
                                    }
                                    </script>
                                    <img onclick="showmodal'.$oSacanas[$i][0].'() " src="../styles/img/delet.svg" alt="Excluir">'
                                            . '<div id="modal'.$oSacanas[$i][0].'" class="modal" style="display: none;">
                                            <div class="content">
                                            <div class="cabeca">
                                                <h2>Você tem certeza?</h2>
                                            </div>    
                                                <hr>
                                                <h3>Este conteúdo vai ser excluído. Tem certeza que deseja continuar?</h3>
                                                
                                            <input type="hidden" value='.$oSacanas[$i][0].'>
                                            <div class="Modaloptions">
                                                <button onclick="closeModal'.$oSacanas[$i][0].'()" id="cancel">Cancelar</button>
                                                <a href="../components/excluir.php?id_livros='.$dTable[$i][5].'&id='.$oSacanas[$i][0].'&tabela='.$tabela.'">
                                                <button>Excluir</button>
                                                </a>
                                                </div>
                                            </div>
                                            </div> </div>
                                            
                                            </td>';
                                                      
                        echo '</tr></div>';}
                    //parte amarela   
                    for ($i=0; $i < $oA; $i++) { 
                            $j=1;
                        echo '<tr>';
                        while($j < $colunas)
                        {
                            echo '<td id=oAvisados>'.$osAvisados[$i][$j].'</td>';
                            $j++; 
                        }
                        echo '<td> <div class="options"><a href="alterar.php?id='.$osAvisados[$i][0].'">'
                                    . '<img src="../styles/img/gear.svg" alt="Editar">'
                                    . '</a> ';         
                        echo '<script>
                                    function showmodal'.$osAvisados[$i][0].'(){
                                        var modal= document.querySelector("#modal'.$osAvisados[$i][0].'")    
                                        modal.style.display= "block"
                        
                                    }
                                    function closeModal'.$osAvisados[$i][0].'(){
                                        var btnClose = document.querySelector("#cancel")
                                        var modal= document.querySelector("#modal'.$osAvisados[$i][0].'")
                                        
                                        modal.style.display= "none"             
                                    }
                                    </script>
                                    <img onclick="showmodal'.$osAvisados[$i][0].'() " src="../styles/img/delet.svg" alt="Excluir">'
                                            . '<div id="modal'.$osAvisados[$i][0].'" class="modal" style="display: none;">
                                            <div class="content">
                                            <div class="cabeca">
                                                <h2>Você tem certeza?</h2>
                                            </div>    
                                                <hr>
                                                <h3>Este conteúdo vai ser excluído.Tem certeza que deseja continuar?</h3>
                                                
                                            <input type="hidden" value='.$osAvisados[$i][0].'>
                                            <div class="Modaloptions">
                                                <button onclick="closeModal'.$osAvisados[$i][0].'()" id="cancel">Cancelar</button>
                                                <a href="../components/excluir.php?id_livros='.$dTable[$i][5].'&id='.$osAvisados[$i][0].'&tabela='.$tabela.'">
                                                <button>Excluir</button>
                                                </a>
                                                </div>
                                            </div>
                                            </div> </div>
                                            
                                            </td>';
                                                      
                        echo '</tr></div>';}
                        //parte normal
                    for ($i=0; $i < $sF; $i++) { 
                            $j=1;
                        echo '<tr>';
                        while($j < $colunas)
                           {
                               echo '<td id=oSafes>'.$oSafes[$i][$j].'</td>';
                            $j++; 
                           }
                           echo '<td> <div class="options"><a href="alterar.php?id='.$oSafes[$i][0].'">'
                                    . '<img src="../styles/img/gear.svg" alt="Editar">'
                                    . '</a> ';
                            echo '<script>
                                    function showmodal'.$oSafes[$i][0].'(){
                                        var modal= document.querySelector("#modal'.$oSafes[$i][0].'")    
                                        modal.style.display= "block"
                        
                                    }
                                    function closeModal'.$oSafes[$i][0].'(){
                                        var btnClose = document.querySelector("#cancel")
                                        var modal= document.querySelector("#modal'.$oSafes[$i][0].'")
                                        
                                        modal.style.display= "none"             
                                    }
                                    </script>
                                    <img onclick="showmodal'.$oSafes[$i][0].'() " src="../styles/img/delet.svg" alt="Excluir">'
                                            . '<div id="modal'.$oSafes[$i][0].'" class="modal" style="display: none;">
                                            <div class="content">
                                            <div class="cabeca">
                                                <h2>Você tem certeza?</h2>
                                            </div>    
                                                <hr>
                                                <h3>Este conteúdo vai ser excluído. Tem certeza que deseja continuar?</h3>
                                                
                                            <input type="hidden" value='.$oSafes[$i][0].'>
                                            <div class="Modaloptions">
                                                <button onclick="closeModal'.$oSafes[$i][0].'()" id="cancel">Cancelar</button>
                                                <a href="../components/excluir.php?id_livros='.$dTable[$i][5].'&id='.$oSafes[$i][0].'&tabela='.$tabela.'">
                                                <button>Excluir</button>
                                                </a>
                                                </div>
                                            </div>
                                            </div> </div>
                                            
                                            </td>';
                                                                           
                        echo '</tr></div>';}
                        for($i = 1; $i < $numPaginas + 1; $i++) { 
                            echo " </table> <a href='index.php?pagina=$i'>".$i."</a> ";
                        }            
                }
                
            }
            if($specialCase!='s' and $specialCase!='r'){
                //listagem de dados livros e leitores e admins
                $cor=1;
                while ($dados = $resultado->fetch_assoc()) { 
                    $j=1;
                    foreach ($dados as $key => $value) {
                        $c[]=$value;}
                        if($cor%2==0){
                            echo '<tr class="escuro">';
                            $cor++;
                        }
                        else{
                            echo '<tr class="claro">';
                            $cor++;
                        }
                while($j <= $colunas){
                        echo '<td>'.$c[$j].'</td>';
                    $j++; 
                    }unset($c);
                    if($specialCase!='h'){
                    
                    echo '<td> <div class="options">';

                     echo '<div class="options"><a href="alterar.php?id='.$dados['id'].'">'
                                    . '<img src="../styles/img/gear.svg" alt="Editar">'
                                    . '</a> ';

                    echo '<script>
                    function showmodal'.$dados['id'].'(){
                        var modal= document.querySelector("#modal'.$dados['id'].'")    
                        modal.style.display= "block"
        
                    }
                    function closeModal'.$dados['id'].'(){
                        var btnClose = document.querySelector("#cancel")
                        var modal= document.querySelector("#modal'.$dados['id'].'")
                        
                        modal.style.display= "none"             
                    }
                    </script>
                    <img onclick="showmodal'.$dados['id'].'() " src="../styles/img/delet.svg" alt="Excluir">'
                            . '<div id="modal'.$dados['id'].'" class="modal" style="display: none;">
                            <div class="content">
                            <div class="cabeca">
                                <h2>Você tem certeza?</h2>
                            </div>    
                                <hr>
                                <h3>Este conteúdo vai ser excluído.Tem certeza que deseja continuar?</h3>
                                
                            <input type="hidden" value='.$dados['id'].'>
                            <div class="Modaloptions">
                                <button onclick="closeModal'.$dados['id'].'()" id="cancel">Cancelar</button>
                                <a href="../components/excluir.php?id='.$dados['id'].'&tabela='.$tabela.'">
                                <button>Excluir</button>
                                </a>
                                </div>
                            </div>
                            </div> </div>
                            
                            </td>';
                                                        
                echo '</div></tr>';
                }}echo"</table>";
                for($i = 1; $i < $numPaginas + 1; $i++) { 
                    if($specialCase=='h'){echo "<a href='historico.php?pagina=$i'>".$i."</a> ";}
                    else{echo "<a href='index.php?pagina=$i'>".$i."</a> ";}
                    
                
            }
        }
             
            //listagem de dados leitores pelo select
            if($specialCase=='s' and $dados[2]=='Retirada'){ 
                $cor=1;
                while ($dados = $resultado->fetch_assoc()) { 
                     $j=1;
                     foreach ($dados as $key => $value) {
                         $c[]=$value;}
                         if($cor%2==0){
                            echo '<tr class="escuro">';
                            $cor++;
                         }
                         else{
                            echo '<tr class="claro">';
                            $cor++;
                         }
                 while($j <= $colunas)
                    {
                        echo '<td>'.$c[$j].'</td>';
                     $j++; 
                    }
            }}
            //listagem de dados qualquer pelo select
            if($specialCase == 's'){ 
                $cor=1;
                if($coluna == "cpf"){
                $local="usuarios/" ;}
                else{$local="livros/";}
                $colunas--;
                
                while ($dados = $resultado->fetch_assoc()) { 
                     $j=1;
                     foreach ($dados as $key => $value) {
                         $c[]=$value;}
                         if($cor%2==0){
                            echo '<tr class="escuro">';
                            $cor++;
                         }
                         else{
                            echo '<tr class="claro">';
                            $cor++;
                         }
                 while($j <= $colunas)
                    {
                        echo '<td>'.$c[$j].'</td>';
                     $j++; 
                    }
                    unset($c);
                    if($especifico != "t"){
                        echo '<td> <div class="options"><a href="../'.$local.'alterar.php?id='.$dados['id'].'">'
                                . '<img src="../styles/img/gear.svg" alt="Editar">'
                                . '</a> ';

                                echo '<script>
                                function showmodal'.$dados['id'].'(){
                                    var modal= document.querySelector("#modal'.$dados['id'].'")    
                                    modal.style.display= "block"
                    
                                }
                                function closeModal'.$dados['id'].'(){
                                    var btnClose = document.querySelector("#cancel")
                                    var modal= document.querySelector("#modal'.$dados['id'].'")
                                    
                                    modal.style.display= "none"             
                                }
                                </script>
                                <img onclick="showmodal'.$dados['id'].'() " src="../styles/img/delet.svg" alt="Excluir">'
                                        . '<div id="modal'.$dados['id'].'" class="modal" style="display: none;">
                                        <div class="content">
                                        <div class="cabeca">
                                            <h2>Você tem certeza?</h2>
                                        </div>    
                                            <hr>
                                            <h3>Este conteúdo vai ser excluído.Tem certeza que deseja continuar?</h3>
                                            
                                        <input type="hidden" value='.$dados['id'].'>
                                        <div class="Modaloptions">
                                            <button onclick="closeModal'.$dados['id'].'()" id="cancel">Cancelar</button>
                                            <a href="../components/excluir.php?id='.$dados['id'].'&tabela='.$tabela.'">
                                            <button>Excluir</button>
                                            </a>
                                            </div>
                                        </div>
                                        </div> </div>
                                        
                                        </td>';               
                }}
                if($coluna=="autor" or $coluna==$nomel){
                    for($i = 1; $i < $numPaginas + 1; $i++) { 
                        echo "<a href='index.php?pagina=$i'>".$i."</a> ";
                    
                    }
                }
            }
    
    }echo '</table>';
    
?>