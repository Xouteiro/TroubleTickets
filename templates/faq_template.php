<?php

declare(strict_types=1); ?>

<?php
function output_faq_page(Session $session){ 


?>
<?php
  require_once(__DIR__ . '/../database/connection.db.php');
  $db = getDataBaseConnection(); ?>
  
        <section id="faq" class="faq">
        <h2>FAQ</h2>
      <?php output_departments($session); ?>
      <?php output_faq_by_department();//param: department?>
         </section>

<?php
}
  ?>

<?php

function output_departments(Session $session){

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../templates/normal.php');
require_once(__DIR__ . '/../templates/faq_template.php');

$db = getDatabaseConnection();
?>
<div class="departments">
    <h3>Department1</h3>
    <h3>Department2</h3>
</div>


<?php
/*for(departments as department){
    <button onCick="change_department()" class="department_change">echo department->name</button>//javascript
}
*/
}

?>




<?php
function output_faq_by_department()
{

?>
<div class="questions">
  <div class="question">
    <h4>What do I do if I forget my password?</h4>
    <p>You can reset your password by clicking the "Forgot Password" link on our website login page.You can reset your password by clicking the "Forgot Password" link on our website login page.You can reset your password by clicking the "Forgot Password" link on our website login page.</p>
  </div>
  <div class="question">
    <h4>What do I do if I forget my password?</h4>
    <p>You can reset your password by clicking the "Forgot Password" link on our website login page.</p>
  </div>
  
</section>
<?php
/*for(faq as f){
    if(faq->department = $department){
      <div class="question">
        <h4>faq->question</h4>
        <p> faq->answer <p>
      </div>
    }
    
}
*/
}
  ?>



