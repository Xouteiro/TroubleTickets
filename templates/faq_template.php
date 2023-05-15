<?php

declare(strict_types=1); ?>

<?php
function output_faq_page(Session $session){ 


?>
<?php
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/department.class.php');
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
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../templates/faq_template.php');

$db = getDatabaseConnection();
$departments = Department::getDepartments($db,10);

?>
<div class="departments">
<?php
foreach($departments as $department) {?>
    <h3><?php echo $department->name?></h3>
    <hr>
<?php } ?>
</div>


<?php
/*for(departments as department){
    <button onCick="change_department()" class="department_change">echo department->name</button>//javascript
}
*/
}

?>




<?php
function output_faq_by_department() {
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/faq.class.php');


  $db = getDataBaseConnection();
  $faqs = FAQ::getFAQS($db,20);
  ?>
  <div class='questions'>
<?php
foreach($faqs as $faq) {
    /*if($faq->department != $department){*/   ?>
      <div class="question">
        <h4><?php echo $faq->question?></h4>
        <p> <?php echo $faq->answer?> </p>
        <hr>
      </div>

   <?php /*} */  
} ?>
</div>
<?php
}
  ?>



