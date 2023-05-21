<?php

declare(strict_types=1); ?>

<?php
function output_faq_page(Session $session)
{


?>
  <?php
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/department.class.php');
  $db = getDataBaseConnection(); ?>
  <section id='full-faq' class='full-faq'>
    <h2>FAQ</h2>
    <section id="faq" class="faq">

      <?php output_departments($session); ?>
      <?php output_faq(); 
      ?>
    </section>
  </section>

<?php
}
?>

<?php

function output_departments(Session $session)
{

  require_once(__DIR__ . '/../utils/session.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/department.class.php');
  require_once(__DIR__ . '/../templates/faq_template.php');

  $db = getDatabaseConnection();
  $departments = Department::getDepartments($db, 10);

?>
  <div class="departments">
      <h3 data-dep-id='0'>All</h3>
      <hr>
    <?php
    foreach ($departments as $department) { ?>
      <h3 data-dep-id='<?php echo $department->id ?>'><?php echo $department->name ?></h3>
      <hr>
    <?php } ?>
  </div>


<?php
}

?>




<?php
function output_faq()
{
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/faq.class.php');


  $db = getDataBaseConnection();
  $faqs = FAQ::getFAQS($db, 20);
?>
  <div class='questions'>
    <?php
    foreach ($faqs as $faq) {   ?>
      <div class="question" data-faq-id='<?php echo $faq->department_id ?>'>
        <h4><?php echo $faq->question ?></h4>
        <p> <?php echo $faq->answer ?> </p>
        <hr>
      </div>

    <?php 
    } ?>
  </div>
<?php
}
?>