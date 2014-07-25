<?

                 echo "<form  action='#' method='post'>";

                  $idpubli        = @$vector_de_publicaciones[$contador]['idpublicacion'];
                  $miembro        =@$_SESSION['miembro'];
                  $dueño_public   =@$vector_de_publicaciones[$contador]['miembro'];
                  $dueño_publi =
                  $idimagen       =@$vector_de_publicaciones[$contador]['idimagen'];
                  $tipo_publi     =@$vector_de_publicaciones[$contador]['idtipo_publi'];
                  $comentarios    =@$vector_de_publicaciones[$contador]['comentarios'];
                  $chivos         =@$vector_de_publicaciones[$contador]['chivos'];
                  $neles          =@$vector_de_publicaciones[$contador]['neles'];
                  $none           = "";

                        $vector_like = @ consultar("
                                          select
                                            miembro_persive,
                                            numero_publicacion
                                          from
                                            who_percepcionchivo
                                          where
                                            miembro_persive = $miembro and
                                            numero_publicacion = $idpubli;
                                      ");
                        $cantidad_like_miembro = count( $vector_like );

                        $vector_nel = consultar("
                                          select
                                            miembro_persive,
                                            numero_publicacion
                                          from
                                            who_percepcionel
                                          where
                                            miembro_persive = $miembro and
                                            numero_publicacion = $idpubli;
                                      ");
                        $cantidad_nel_miembro = count( $vector_nel );

                    if (!$chivos && $cantidad_nel_miembro){
			               #nadie le a dado me gusta, pero le has dado no me gusta
			                echo "<span class='iconlike vistalike-default' title='esta chivo' ><span class='glyphicon glyphicon-thumbs-up'></span></span> <b>".$none."</b> &nbsp &nbsp";
                    }
                    if (!$chivos && !$cantidad_nel_miembro){
			                echo "<span class='iconlike vistalike-default' title='esta chivo' ><span class='glyphicon glyphicon-thumbs-up'></span></span> <b>".$none."</b> &nbsp &nbsp";
                    }
                    if ( $chivos && $cantidad_like_miembro ) {
			                #le has dado me gusta: aparece encendido, si le das de nuevo retiras el me gusta
			                verlikesy ($idpubli, $chivos);
                    }
                    if ($chivos && !$cantidad_like_miembro) {
			                #no le has dado me gusta: aparece apagado
			                verlikes ($idpubli, $chivos);
                    }

                    if (!$neles && $cantidad_like_miembro){
			                #nadie le a dado no me gusta, pero le has dado me gusta
			                echo "<span class='iconnolike vistanolike-default' title='no me gusta'><span class='glyphicon glyphicon-thumbs-down'></span></span> <b>".$none."</b>";
                    }
                    if ( !$neles && !$cantidad_like_miembro) {
                      echo "<span class='iconnolike vistanolike-default' title='no me gusta'><span class='glyphicon glyphicon-thumbs-down'></span></span> <b>".$none."</b>";
                    }
                    if ($neles && $cantidad_nel_miembro) {
 			                #le has dado no me gusta: aparece encendido, si le das de nuevo retiras el no me gusta
			                nelesy ($idpubli, $neles);
                    }
                    if ($neles && !$cantidad_nel_miembro) {
                      #no le has dado no me gusta: aparece apagado
                      neles($neles, $idpubli);
                    }

                    if (!$comentarios){
                     echo "&nbsp <span class='iconlike vistalike-default' title='comentarios' ><span class='glyphicon glyphicon-comment'></span></span> <b>".$none."</b>";
                    }else{
                      echo "&nbsp <span class='iconlike vistalike-default' title='comentarios' ><span class='glyphicon glyphicon-comment'></span></span> <b>".$comentarios."</b>";
                    }


                  echo "<input type='hidden' name='id' value='$idpubli'>";
                  echo "<input type='hidden' name='idmiembro' value='$miembro'>";
                  echo "<input type='hidden' name='dueno' value='$dueño_public'>";
                  echo "<input type='hidden' name='idim' value='$idimagen'>";
                  echo "<input type='hidden' name='tipo' value='$tipo_publi'>";
                 echo "</form>";


?>

