<?php
/*
 * Template Name: Contact 
 */
?>

<?php 

/* ----------------------------------------------------------------
 * Contact form functions
 * ----------------------------------------------------------------*/
$nameError = '';
$emailError = '';
$commentError = '';

if(isset($_POST['submitted'])) {
  if(trim($_POST['contact-name']) === '') {
    $nameError = 'Please enter your name.';
    $hasError = true;
  } else {
    $name = trim($_POST['contact-name']);
  }
  
  if(trim($_POST['email']) === '')  {
    $emailError = 'Please enter your email address.';
    $hasError = true;
  } else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
    $emailError = 'You entered an invalid email address.';
    $hasError = true;
  } else {
    $email = trim($_POST['email']);
  }
    
  if(trim($_POST['comments']) === '') {
    $commentError = 'Please enter a message.';
    $hasError = true;
  } else {
    if(function_exists('stripslashes')) {
      $comments = stripslashes(trim($_POST['comments']));
    } else {
      $comments = trim($_POST['comments']);
    }
  }
			
  if(!isset($hasError)) {
    $emailTo = get_option('tz_email');
    if (!isset($emailTo) || ($emailTo == '') ){
      $emailTo = get_option('admin_email');
    }
    $subject = '[Contact Form] From '.$name;
    $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
    $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
    
    mail($emailTo, $subject, $body, $headers);
    $emailSent = true;
  }
	
}
/* ----------------------------------------------------------------
 * Contact form 
 * ----------------------------------------------------------------*/
get_header(); ?>

<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>

    <?php if(isset($emailSent) && $emailSent == true) { ?>

      <div class="thanks">
        <p><?php _e('Thanks, your email was sent successfully.', 'framework') ?></p>
      </div>

    <?php } else { ?>

      <?php if(isset($hasError) || isset($captchaError)) { ?>
        <p class="error"><?php _e('Sorry, an error occured.', 'framework') ?><p>
      <?php } ?>

      <form action="<?php the_permalink(); ?>" id="contact-form" method="post">

        <p>
          <label for="contact-name"><?php _e('Name:', 'framework') ?></label>
          <input type="text" name="contact-name" id="contact-name" value="<?php if(isset($_POST['contact-name'])) echo $_POST['contact-name'];?>" class="required requiredField" />
          <?php if($nameError != '') { ?>
            <span class="error"><?php echo $nameError; ?></span> 
          <?php } ?>
        </p>

        <p>
          <label for="email"><?php _e('Email:', 'framework') ?></label>
          <input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" />
          <?php if($emailError != '') { ?>
            <span class="error"><?php echo $emailError; ?></span>
          <?php } ?>
        </p>

        <p>
          <label for="comments-text"><?php _e('Message:', 'framework') ?></label>
            <textarea name="comments" id="comments-text" rows="20" cols="30" class="required requiredField">
              <?php if(isset($_POST['comments'])) { 
                if(function_exists('stripslashes')) { 
                  echo stripslashes($_POST['comments']); 
                } else { 
                  echo $_POST['comments']; 
                } 
              } ?>
            </textarea>
            <?php if($commentError != '') { ?>
              <span class="error"><?php echo $commentError; ?></span> 
            <?php } ?>
        </p>

        <p>
          <input type="hidden" name="submitted" id="submitted" value="true" />
          <button name="submit" type="submit" id="submit" tabindex="5">
            <?php _e('Send Email', 'framework') ?>
          </button>
        </p>

      </form>
    <?php } ?>

	</div><!-- .entry-content-->

	<footer class="entry-meta">
		<?php edit_post_link( __( '[Edit]', 'framework' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->

</article><!-- #post-<?php the_ID(); ?> -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
