                <?php
                $Post = new db_query("SELECT * FROM post INNER JOIN title ON (post.title_id = title.title_id) WHERE title.title_id = ".$cat_id." ORDER BY post_id DESC");
                    
                while($row = mysql_fetch_assoc($Post->result)){
                    $string = removeTitle($row['post_name']);
                    $string2 = removeTitle($row['title_name']);
                    $Comment = new db_query("SELECT comment_id FROM comment WHERE post_id=".$row["post_id"]);
                    $count = mysql_num_rows($Comment->result);
                    echo $form = '<div class="post">
                        <div class="col-md-1">
                            <div class="time">
                                <div class="month">'
                                    .date("M", $row["post_time"]).
                                '</div>
                                <div class="day">'
                                    .date("d", $row["post_time"]).
                                '</div>
                            </div>
                            <div class="img-title">
                                <img src="/admin/themes/images/'.$row["title_image"].'">
                            </div>
                        </div>
                        <div class="col-md-11">
                            <div class="img">
                                <a href="/detail/'.$string2.'/'.$string.'-'.$row["post_id"].'"><img src="/admin/themes/images/'.$row["post_image"].'"></a>
                            </div>
                            <div class="contain">
                                <h4><a href="/detail/'.$string2.'/'.$string.'-'.$row["post_id"].'">'.$row["post_name"].'</a></h4>
                                <span>Posted by <a href="">'.$row["post_author"].'</a> in <a href="">'.$row["title_name"].'</a></span>
                                <img class="com-img" src="/images/comm.png"><a href="/index/'.$string2.'/'.$string.'-'.$row["post_id"].'#comment-list">'.$count.'</a>
                                <p>'.substr($row["post_detail"],0,1000)."...".'</p>
                                <a href="/detail/'.$string2.'/'.$string.'-'.$row["post_id"].'">Continue reading -></a>
                            </div>
                        </div>
                    </div>';
                    // getChild($form, $cat_id);
                }
                ?>
                