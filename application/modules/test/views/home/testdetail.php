
<section class="content">
   <div class="row">
      <div class="col-md-10">
         <!-- Hiển thị các danh ĐỀ THI của content -->
         <form action="" method="post">
            <div class="box box-success">
               <!-- Title của đề thi -->
               <div class="row" style="padding-top: 20px;">
                  <div class="col-md-5">
                     <p class="text-center" style="font-size: 18px;"><b>Trường Đại học Bách Khoa Hà Nội</b></p>
                     <p class="text-center" style="font-size: 16px;"><b>Dự án đào tạo HEDSPI</b></p>
                  </div>
                  <div class="col-md-6 col-md-offset-1">
                     <p class="text-center" style="font-size: 16px;"><b>
                        <?php if(isset($test_info) && !empty($test_info)){
                           echo "Đề thi: ".$test_info['name']."<br>";
                           echo 'Mã đề thi: '.$test_info['madethi'].'<br/>';
                           echo 'Thời gian: '.$test_info['time'].' phút'.'<br/>';
                           echo 'Số lượng câu: '.$test_info['sl'].'<br/>';
                           }?>
                        </b>    
                     </p>
                  </div>
               </div>
               <div class="box-header">
                  <p class="pull-right"><b>Lưu ý:</b> Một câu hỏi có thể có nhiều hơn một đáp án đúng.</p>
         </form>
         
         <a href="test/printTest/<?php if(isset($test_info) && !empty($test_info)) echo $test_info['id'];?>" class="btn btn-primary">Click to Print this Test >>></a>
         </form>
         <div class="divider divider2"></div>
         </div>
         <div class="text-center delay"><p>Bạn sẽ bắt đầu trong 5s</p></div>
         
         <div class="box-body">
         <?php if(isset($test) && !empty($test)){
            $number_question = 1;
            foreach($test as $key=>$val){?>
         <div class="clearfix cauhoi-wrap chanle">
         <span class="cauhoi"><?php echo $number_question++;?>. <?php echo $val['question'];?></span>
         <div class="form-group">
         <?php if(isset($val['answer']) && !empty($val['answer'])){
            $answer_choice = json_decode($val['answer'],true);?>
         <?php $number_choice = count($answer_choice);
            for($choice = 1; $choice<= $number_choice; $choice++){?>
         <?php if(isset($answer_choice[$choice]) && !empty($answer_choice[$choice])){?>
         <div class="radio">
         <label>
         <input type="checkbox" value="<?php echo $choice;?>" name="answer[<?php echo $key;?>][]">
         <?php echo $answer_choice[$choice];?>
         </label>
         </div>
         <?php }?>
         <?php }?>
         <?php }?>                     
         </div>
         </div>   
         <?php 
            }
            }?>   
         <div class="divider divider2"></div>
         <div class="col-md-6 col-md-offset-5"> 
         <input type="submit" class="btn btn-success" name="submit" value="Nộp bài">
         </div>
         </div>
         </div>
      </div>
      <!-- Time -->
     
      <div id="practiceScore" style="display: block;">
         <table style="width: 15 0px">
            <tbody>
               <tr>
                  <td>Thời gian còn lại:</td>
               </tr> 
               <tr>
                   <td style="text-align : center;">
                     <span id="phut"><?php echo $test_info['time']?></span>
                     :
                     <span id="giay">00</span>
                  </td>
               </tr>
            </tbody>
             <tr>
                  <!--<td><a type ="submit" id="testFinish" class="button" name="submit" value="Nộp bài">Nộp Bài</a></td>-->
                  <td>
                  <form method="post" action="">
                     <input type="submit"  id ="testFinish" class="button" name="submit" value="Nộp bài">
                  </form>
                  </td>
             </tr> 
         </table>
      </div>
      <!-- end Time -->
   </div><!-- Row-->
</section>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
      $(window).ready(function(){
        $(window).scroll(function(){
          var top=$(window).scrollTop();
          if (top>20) {
            $('#practiceScore').addClass('fixed');
          }else{
            $('#practiceScore').removeClass('fixed');          }
        })
      })
</script>
 <script type="text/javascript">
      $(document).ready(function(){
         var m = <?php echo $test_info['time'] ?>; // Phút
         var s = 6; // Giây
         var timeout = null;
         function start(){
         if (s === -1){
                    m -= 1;
                    s = 59;
                }
         if (m == -1){
                    clearTimeout(timeout);
                    alert('Hết giờ');
                    return false;
                }

         $('#phut').html('').html(m);
         $('#giay').html('').html(s);

         timeout = setTimeout(function(){
                    s--;
                    start();
                }, 1000);

         }
         start();

         $('.box-body').hide();
         setTimeout(function(){
            $('.box-body').fadeIn(300);
            $('.delay').fadeOut(300);
         },5000);
      })
         
   </script>
