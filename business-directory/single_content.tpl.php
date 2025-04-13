<?php
/**
 * Listing detail view rendering template
 *
 * @package BDP/Templates/Single Content
 */

?>
<!--single_content.tpl.php-->

<?php echo $fields->subtitle->html; ?>
<?php echo $fields->name->html; ?>
<div class="wpbdp-year-inst-block">
<?php echo $fields->year->html; ?>
|
<?php echo $fields->institution->html; ?>
</div>
<div class="wpbdp-metadata-block">
<?php echo $fields->methodology->html; ?>
<?php echo $fields->participants->html; ?>
<?php echo $fields->data_collection->html; ?>
<?php echo $fields->data_analysis->html; ?>
</div>
<?php if ( $fields->full_text_thesis->html > "" | $fields->published_paper->html > "" | $fields->blog__news_story->html > "" | $fields->website->html > "" ) : ?>
    <div class="wpbdp-further-reading-block">
    <h2>Further reading</h2>
    <ul>
<?php endif; ?>

<?php if ( $fields->full_text_thesis->html > "" ) : ?>
    <li>
        <a href="<?php echo $fields->full_text_thesis->raw[0]; ?>">Full text thesis</a>
</li>
<?php endif; ?>


<?php if ( $fields->published_paper->html > "" ) : ?>
    <li>
        <a href="<?php echo $fields->published_paper->raw[0]; ?>">Published paper</a>
</li>
<?php endif; ?>

<?php if ( $fields->blog__news_story->html > "" ) : ?>
    <li>
        <a href="<?php echo $fields->blog__news_story->raw[0]; ?>">Blog / news story</a>
</li>
<?php endif; ?>

<?php if ( $fields->website->html > "" ) : ?>
    <li>
    <?php echo $fields->website->html; ?>
</li>
<?php endif; ?>
</ul>
</div>

<h2>Abstract</h2>
<?php echo wpautop($fields->abstract->raw); ?>



<?php // echo $fields->html; ?>
<?php if ( $fields->share_email->value == 'Yes' ) : ?>
    <h2 class="wpbdp-contact">Contact <?php echo $fields->name->raw; ?></h2>
    <?php echo $fields->email->html; ?>
<?php endif; ?>
