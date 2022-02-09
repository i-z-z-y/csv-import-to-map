<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content/content-single' );

endwhile; // End of the loop.
//////////////////////////////////////////////////////////////////////////
//echo 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz   ' . get_the_id() ;
// echo get_permalink( get_the_id() );
////////////////////////////////////////////////// GOOGLE MAP ?>

<div id="googleMap" style="width:100%;height:400px;"></div>

<script>
function myMap() {
var mapProp= {
 center:new google.maps.LatLng(1.508742,-0.120850),
 zoom:3,
};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

<?php
$testy = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE post_id = " . get_the_id(), ARRAY_A);
  $arrayx = unserialize($testy['meta_value']);

  // The marker
  foreach ( $arrayx as $arrayz ) {
      echo "var marker".$arrayx[0][0] ." = new google.maps.Marker({";
      echo "position: new google.maps.LatLng(". $arrayz[6] .",".$arrayz[7] ."),";
      echo "map: map,";
      echo "});";
  }
?>

}

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhh1TqybbSqdGgkuQf5BaovhPR3-Uvb3s&callback=myMap"></script>

    <?php /////////////////////////////// GOOGLE MAP


get_footer();