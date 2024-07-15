<?php
add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup() {
  load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'html5', array( 'search-form' ) );
  global $content_width;
  if ( ! isset( $content_width ) ) { $content_width = 1920; }
  register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'blankslate' ) ) );
}
add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_load_scripts() {
  wp_enqueue_style( 'blankslate-style', get_stylesheet_uri() );
  wp_enqueue_script( 'custom-scripts', get_template_directory_uri() . '/assets/js/scripts.js' );
  wp_enqueue_script( 'jquery' );
}
add_action( 'wp_footer', 'blankslate_footer_scripts' );
function blankslate_footer_scripts() {
  ?>
<script>
    jQuery(document).ready(function ($) {
        var deviceAgent = navigator.userAgent.toLowerCase();
        if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
            $("html").addClass("ios");
            $("html").addClass("mobile");
        }
        if (navigator.userAgent.search("MSIE") >= 0) {
            $("html").addClass("ie");
        } else if (navigator.userAgent.search("Chrome") >= 0) {
            $("html").addClass("chrome");
        } else if (navigator.userAgent.search("Firefox") >= 0) {
            $("html").addClass("firefox");
        } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
            $("html").addClass("safari");
        } else if (navigator.userAgent.search("Opera") >= 0) {
            $("html").addClass("opera");
        }
    });
</script>
<?php
}
add_filter( 'document_title_separator', 'blankslate_document_title_separator' );
function blankslate_document_title_separator( $sep ) {
  $sep = '|';
  return $sep;
}
add_filter( 'the_title', 'blankslate_title' );
function blankslate_title( $title ) {
  if ( $title == '' ) {
    return '...';
  } else {
    return $title;
  }
}
add_filter( 'the_content_more_link', 'blankslate_read_more_link' );
function blankslate_read_more_link() {
  if ( ! is_admin() ) {
    return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">...</a>';
  }
}
add_filter( 'excerpt_more', 'blankslate_excerpt_read_more_link' );
function blankslate_excerpt_read_more_link( $more ) {
  if ( ! is_admin() ) {
    global $post;
    return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">...</a>';
  }
}
add_filter( 'intermediate_image_sizes_advanced', 'blankslate_image_insert_override' );
function blankslate_image_insert_override( $sizes ) {
  unset( $sizes['medium_large'] );
  return $sizes;
}
add_action( 'widgets_init', 'blankslate_widgets_init' );
function blankslate_widgets_init() {
  register_sidebar( array(
  'name' => esc_html__( 'Sidebar Widget Area', 'blankslate' ),
  'id' => 'primary-widget-area',
  'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>',
      ) );
    }
    add_action( 'wp_head', 'blankslate_pingback_header' );
    function blankslate_pingback_header() {
      if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
      }
    }
    add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
    function blankslate_enqueue_comment_reply_script() {
      if ( get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
      }
    }
    function blankslate_custom_pings( $comment ) {
      ?>
<li <?php comment_class(); ?> id="li-comment-
    <?php comment_ID(); ?>">
    <?php echo comment_author_link(); ?>
</li>
<?php
    }
    add_filter( 'get_comments_number', 'blankslate_comment_count', 0 );
    function blankslate_comment_count( $count ) {
      if ( ! is_admin() ) {
        global $id;
        $get_comments = get_comments( 'status=approve&post_id=' . $id );
        $comments_by_type = separate_comments( $get_comments );
        return count( $comments_by_type['comment'] );
      } else {
        return $count;
      }
    }

function add_file_types_to_uploads($file_types){
$new_filetypes = array();
$new_filetypes['svg'] = 'image/svg+xml';
$file_types = array_merge($file_types, $new_filetypes );
return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

//add_action( 'gform_after_submission', 'after_submission', 10, 2 );

function splash_page() {
  ob_start();
  ?>
<div id="splash-page">
    <div class="splash-col">
        <h2 class="col-title">Plan of Action</h2>
        <div class="report-btns-box">
            <a href="poa-form" class="report-btn">
                <p class="form-title">Full Service POA</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="/poa-marketing-analytics/" class="report-btn">
                <p class="form-title">Agency + Analytics</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="/poa-marketing-hr/" class="report-btn">
                <p class="form-title">Agency + HR & Team Support</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="/poa-analytics-hr/" class="report-btn">
                <p class="form-title">Analytics + HR & Team Support</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="/poa-analytics/" class="report-btn">
                <p class="form-title">Analytics</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="/poa-hr/" class="report-btn">
                <p class="form-title">HR & Team Support</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
        </div>
        <h2 class="col-title">HR & Team Reports</h2>
        <div class="report-btns-box">
            <a href="/employer-of-choice/" class="report-btn">
                <p class="form-title">Employer Of Choice</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
        </div>
    </div>
    <div class="splash-col">
        <h2 class="col-title">Marketing Reports</h2>
        <div class="report-btns-box">
            <a href="https://vetmarketingreport.com/client-retention/" class="report-btn" target="_blank">
                <p class="form-title">Active Client Retention Scorecard</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="https://vetmarketingreport.com/competitor-analysis/" class="report-btn" target="_blank">
                <p class="form-title">Competitor Analysis Report</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="https://vetmarketingreport.com/google-ads-report/" class="report-btn" target="_blank">
                <p class="form-title">Google Ads Report</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="https://vetmarketingreport.com/vmbr-form/" class="report-btn" target="_blank">
                <p class="form-title">Marketing Benchmark Report</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="https://vetmarketingreport.com/scorecard/" class="report-btn" target="_blank">
                <p class="form-title">Marketing Scorecard Report</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
            <a href="https://vetmarketingreport.com/marketing-plan/" class="report-btn" target="_blank">
                <p class="form-title">Marketing Plan</p>
                <i class="fas fa-long-arrow-alt-right arrow"></i>
            </a>
        </div>
    </div>
</div>
<?php
  return ob_get_clean();
}
add_shortcode('splash_page','splash_page');

function poa_sidebar() {
  ob_start();
  ?>
<div id="poa-sidebar">
    <h2 class="section-title">Form Sections</h2>
    <div id="poa-sidebar-inner">
        <a href="#marketing">Marketing</a>
        <a href="#analytics">Analytics</a>
        <a href="#hrt">HR & Training</a>
        <a href="#plan">Plan</a>
    </div>
</div>
<?php
  return ob_get_clean();
}
add_shortcode('poa_sidebar','poa_sidebar');

function poa_results() {
  ob_start();
  if(isset($_GET['entry_id'])){
	  $entry_id = $_GET['entry_id'];
	  esc_html($entry_id);
	  if(strlen($entry_id) == 2){
		   //old entry id
		   $entry = GFAPI::get_entry( $entry_id );
           esc_html($entry);

	  }else{
           //new unique id
		  $search_criteria = array(
			'status' => 'active',
			'field_filters' => array(
			array( 'key' => '316', 'value' => $entry_id ),
			),
		  );

		if (is_page(88)) {
		  $form = '7';
		} elseif (is_page(94)) {
		  $form = '6';
		} elseif (is_page(98)) {
		  $form = '8';
		} elseif (is_page(103)) {
		  $form = '4';
		} elseif (is_page(99)) {
		  $form = '5';
		} else {
		  $form = '2';
		}

		  $entries = GFAPI::get_entries( $form, $search_criteria );

		  $entry = rgar( $entries, 0 );
		  esc_html($entry);
	  }
  }
  ?>

<?php /* <pre><?php print_r($entry); ?>
</pre> */ ?>

<div id="poa-page">
    <!-- HERO START -->
    <div id="hero-outer">
        <div id="hero-inner">
            <div id="hero-text">
                <h1>Plan of Action</h1>
                <?php
          $source = $entry['256'];
          $date = new DateTime($source);
          ?>
                <h2>
                    <?php echo $entry['40']; ?>
                </h2>
                <p>
                    <?php echo $date->format('F d, Y'); ?>
                </p>
            </div>
        </div>
        <svg id="hero-wave" width="1600" height="120" viewBox="0 0 1600 120" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M-3 3.62242e-05C791 -0.000102603 786.5 96.4999 1600.5 121.5L1600.5 -0.000244141L-3 3.62242e-05Z"
                fill="#152C5D" />
        </svg>
    </div>
    <!-- HERO END -->
    <!-- RESULTS START -->
    <div id="results-outer">
        <div id="results-inner">
            <!-- TOGGLE START -->
            <div id="poa-toggle">
                <div class="toggle active-toggle" id="scorecards-toggle">
                    <p>Scorecards</p>
                </div>
                <div class="toggle" id="plan-toggle">
                    <p>Your Plan</p>
                </div>
            </div>
            <!-- TOGGLE END -->
            <!-- SCOREDCARD START -->
            <div id="scorecard-results" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Marketing Scorecards</p>
                        </div>
                        <div class="report-btns">
                            <div class="toggle-btns">
                                <div class="toggle-cover"></div>
                                <i class="fas fa-arrow-left left-report-btn" id="marketing-left"></i>
                                <p>Report <span class="report-number" id="marketing-numbers">1</span> of 5</p>
                                <i class="fas fa-arrow-right right-report-btn" id="marketing-right"></i>
                            </div>
                            <p class="view-all-btn" id="marketing-all">View All</p>
                        </div>
                    </div>
                    <div class="report marketing-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Website Characteristics</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Category</p>
                                </div>
                                <div class="col-two">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-three">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-four">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Domain Name Set Up</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>86.9% of hospitals have their domain name set up correctly</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['1'] == 'Yes' || $entry['1'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['1'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['119'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['119'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Mobile Responsive Website</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>94.1% of hospitals have a mobile responsive website</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['2'] == 'Yes' || $entry['2'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['2'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['120'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['120'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>SSL Certificates</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>83.2% of hospitals have a secure website</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['4'] == 'Yes' || $entry['4'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['4'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['121'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['121'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Search Engine Optimization (SEO)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>18.2% of hospitals have an SEO optimized website</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['5'] == 'Yes' || $entry['5'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['5'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['122'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['122'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Google Analytics</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>83.4% of hospitals have Google Analytics installed</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['6'] == 'Yes' || $entry['6'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['6'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['123'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['123'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>ADA Accessibility</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>52.2% of hospitals have an ADA compliant website</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['9'] == 'Yes' || $entry['9'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['9'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['124'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['124'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Website Page Speed</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>4.2s average website load time</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['257'] == 'Yes' || $entry['257'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['257'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['125'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['125'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Website Experience - Performance</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Average performance score of 37</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['258'] == 'Yes' || $entry['258'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['258'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['126'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['126'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Website Experience - Accessibility</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Average accessibility score of 83</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['259'] == 'Yes' || $entry['259'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['259'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['127'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['127'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Website Experience - Best Practices</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Average best practices score of 73</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['260'] == 'Yes' || $entry['260'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['260'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['128'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['128'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Website Experience - SEO</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Average SEO score of 86</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['261'] == 'Yes' || $entry['261'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['261'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['129'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['129'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report marketing-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Google Characteristics</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Category</p>
                                </div>
                                <div class="col-two">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-three">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-four">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Google Reviews</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals have an average of 165 Google Reviews</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['262'] == 'Yes' || $entry['262'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['262'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['130'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['130'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Google Star Rating (Out of 5)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals have an average star rating of 4.6</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['263'] == 'Yes' || $entry['263'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['263'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['131'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['131'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>GMB Claimed</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>89% of hospitals have claimed their GMB Listing</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['12'] == 'Yes' || $entry['12'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['12'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['132'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['132'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>GMB Appointment Link</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>28.8% of hospitals have a GMB Appointment Link</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['13'] == 'Yes' || $entry['13'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['13'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['133'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['133'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>GMB Questions & Answers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>23.9% of hospitals are using GMB Questions & Answers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['39'] == 'Yes' || $entry['39'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['39'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['134'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['134'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Number of GMB Questions</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals have an average of 4 GMB Questions</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['264'] == 'Yes' || $entry['264'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['264'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['135'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['135'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>GMB Posts</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>32.9% of hospitals are utilizing GMB Posts</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['16'] == 'Yes' || $entry['16'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['16'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['136'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['136'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>GMB Offers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>5.3% of hospitals are utilizing GMB Offers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['17'] == 'Yes' || $entry['17'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['17'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['137'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['137'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>GMB Description</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>44.5% of hospitals have a GMB Description</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['18'] == 'Yes' || $entry['18'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['18'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['138'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['138'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Google Short Name</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>23% of hospitals have a Google Short Name</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['19'] == 'Yes' || $entry['19'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['19'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['139'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['139'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Google Ads</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>10.5% of hospitals are utilizing GMB Offers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['11'] == 'Yes' || $entry['11'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['11'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['140'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['140'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report marketing-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Facebook Characteristics</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Category</p>
                                </div>
                                <div class="col-two">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-three">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-four">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Recommendations</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>40 Facebook Recommendations for the average hospital</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['265'] == 'Yes' || $entry['265'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['265'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['141'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['141'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Star Rating (Out of 5)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals have an average star rating of 4.7</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['266'] == 'Yes' || $entry['266'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['266'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['142'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['142'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Likes</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals average 1,403 Facebook Likes</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['267'] == 'Yes' || $entry['267'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['267'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['143'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['143'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Followers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals average 1,493 Facebook Followers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['268'] == 'Yes' || $entry['268'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['268'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['144'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['144'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Check-Ins</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals average 733 Facebook Check-Ins</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['269'] == 'Yes' || $entry['269'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['269'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['145'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['145'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Username</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>81.6% of hospitals have a Facebook Username</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['21'] == 'Yes' || $entry['21'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['21'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['146'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['146'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Branding</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>63.9% of hospitals have a Facebook Branded page</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['20'] == 'Yes' || $entry['20'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['20'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['147'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['147'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Messenger</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>83.3% of hospitals are using Facebook Messenger</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['23'] == 'Yes' || $entry['23'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['23'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['148'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['148'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Offers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>7.4% of hospitals are using Facebook Offers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['24'] == 'Yes' || $entry['24'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['24'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['149'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['149'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Facebook Ads</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>8% of hospitals are using Facebook Ads</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['56'] == 'Yes' || $entry['56'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['56'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['150'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['150'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report marketing-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Yelp Characteristics</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Category</p>
                                </div>
                                <div class="col-two">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-three">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-four">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Yelp Reviews</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals average 34 Yelp Reviews</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['270'] == 'Yes' || $entry['270'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['270'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['151'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['151'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Yelp Star Rating (Out of 5)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals have an average star rating of 4</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['271'] == 'Yes' || $entry['271'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['271'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['152'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['152'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Yelp Not Recommended</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals average 18 Yelp Not Recommended Reviews</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['272'] == 'Yes' || $entry['272'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['272'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['153'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['153'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Yelp Claimed</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>45% of hospitals have claimed their Yelp Business Listing</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['28'] == 'Yes' || $entry['28'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['28'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['154'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['154'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Yelp Check-In Offers</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>8.9% of hospitals haver a Yelp Check-In Offer</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['30'] == 'Yes' || $entry['30'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['30'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['155'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['155'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Yelp Ask the Community</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>3.5% of hospitals are using Yelp Ask the Community</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['32'] == 'Yes' || $entry['32'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['32'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['156'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['156'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Number of Yelp Questions</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals average .3 Yelp Questions</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['273'] == 'Yes' || $entry['273'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['273'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['157'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['157'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Yelp Ads</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>17.5% of hospitals are utilizing Yelp Ads</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['29'] == 'Yes' || $entry['29'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['29'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['158'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['158'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Yelp Deals</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>0.7% of hospitals are offering a Yelp Deal</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['31'] == 'Yes' || $entry['31'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['31'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['159'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['159'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Yelp Connect (Posts)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>0.2% of hospitals are using Yelp Posts</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['59'] == 'Yes' || $entry['59'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['59'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['160'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['160'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report marketing-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Nextdoor Characteristics</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Category</p>
                                </div>
                                <div class="col-two">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-three">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-four">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Nextdoor Claimed</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>33% of hospitals have claimed their Nextdoor Listing</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['35'] == 'Yes' || $entry['35'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['35'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['161'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['161'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Nextdoor Recommendations</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals have an average of 92 Nextdoor Recommendations</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['274'] == 'Yes' || $entry['274'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['274'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['162'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['162'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Nextdoor Favorites</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Hospitals have an average of 5 Neighborhood Favorites</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['275'] == 'Yes' || $entry['275'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['275'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['163'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['163'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Nextdoor Local Deals</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>0.6% are utilizing Nextdoor Local Deals</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['38'] == 'Yes' || $entry['38'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['38'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['164'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['164'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if ($entry['63'] != null) { ?>
                <div class="scorecard-section" id="analytics-section">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Analytics Scorecards</p>
                        </div>
                        <div class="report-btns">
                            <div class="toggle-btns">
                                <div class="toggle-cover"></div>
                                <i class="fas fa-arrow-left left-report-btn" id="analytics-left"></i>
                                <p>Report <span class="report-number" id="analytics-numbers">1</span> of 2</p>
                                <i class="fas fa-arrow-right right-report-btn" id="analytics-right"></i>
                            </div>
                            <p class="view-all-btn" id="analytics-all">View All</p>
                        </div>
                    </div>
                    <div class="report analytics-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Financial</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Category</p>
                                </div>
                                <div class="col-two">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-three">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-four">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Practice Revenue Growth</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>
                                        <$2.5M: 10%+ Growth over prior year<br>
                                            >$2.5M: 8%+ Growth over prior year
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['63'] == 'Yes' || $entry['63'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['63'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['165'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['165'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Discounting</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Less than 5% of net revenue</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['65'] == 'Yes' || $entry['65'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['65'] === 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg" alt="">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['166'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['166'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Gross Margin (Revenue less COGS)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Above 75%</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['66'] == 'Yes' || $entry['66'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['66'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['167'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['167'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>OPEX Margin (Operational expenses as % of revenue)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Less than 65%</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['67'] == 'Yes' || $entry['67'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['68'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['168'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['168'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>EBITDA Margin (Includes owners salary)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Minimum 15%</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['68'] == 'Yes' || $entry['68'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['68'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['169'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['169'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Financial Statement timeliness</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Books should be closed out by the 20th of the following month, not counting
                                        year-end close out.</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['69'] == 'Yes' || $entry['69'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['69'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['170'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['170'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Chart of Accounts</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Sufficient detail in variable expense, and other operating expenses and proper
                                        coding of accounts.</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['70'] == 'Yes' || $entry['70'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['70'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['171'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['171'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report analytics-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Operational</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Category</p>
                                </div>
                                <div class="col-two">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-three">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-four">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Practice Average Transaction Charge</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two" style="flex-dirction: column;">
                                    <p>$185 per transaction (Under $2.5 Million in Revenue).<br>
                                        $225 per transaction (Over $2.5 Million in Revenue).<br>
                                        Total revenue divided by total transactions for the same period of time.</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['73'] == 'Yes' || $entry['73'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['73'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['172'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['172'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Revenue per FTE</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>$120k (Includes DVMs and all support staff)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['74'] == 'Yes' || $entry['74'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['74'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['173'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['173'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>FTE per DVM</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Under 4.5 FTE per DVM FTE</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['75'] == 'Yes' || $entry['75'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['75'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['174'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['174'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Revenue Per DVM</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>$660K per DVM. Total revenue for the year divided by the FTE DVM count for same
                                        period of time.</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['76'] == 'Yes' || $entry['76'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['76'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['175'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['175'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Revenue Per Square Foot (SqFt)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>$500 per square foot</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['77'] == 'Yes' || $entry['77'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['77'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['176'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['176'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Revenue Per Exam Room</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>$520k per exam room</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['78'] == 'Yes' || $entry['78'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['78'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['177'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['177'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Number of Transactions Per DVM</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>4500 transactions per DVM. Total transactions for the year divided by FTE DVM
                                        count.</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['79'] == 'Yes' || $entry['79'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['79'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['178'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['178'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Revenue Category Detail</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Sufficient detail in Revenue categories for benchmarking and easy identification
                                        of revenue centers.</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['80'] == 'Yes' || $entry['80'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['80'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['179'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['179'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                <div class="row-inner">
                  <div class="col-one">
                    <p>Front Office Staff Call Conversion Rate</p>
                  </div>
                  <div class="col-two">
                    <p>Total Conversion should be at least 80% from website traffic.</p>
                  </div>
                  <div class="col-three">
                    <?php if ($entry['conversion_rate'] == 'Yes' || $entry['conversion_rate'] == 'Pass') { ?>
                      <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" />
                    <?php } elseif ($entry['conversion_rate'] == 'TBD') { ?>
                      <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg" alt="Minus mark">
                    <?php } else { ?>
                      <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg" alt="Minus mark" />
                    <?php } ?>
                  </div>
                  <div class="col-four">
                    <?php if ($entry['notes_62'] == null) { ?>
                      <p class="no-notes">N/A</p>
                    <?php } else { ?>
                      <p><?php echo $entry['notes_62'] ?></p>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="row-inner">
                  <div class="col-one">
                    <p>Front Office Live Answer Rate</p>
                  </div>
                  <div class="col-two">
                    <p>Live answer rates should be at least 95%.</p>
                  </div>
                  <div class="col-three">
                    <?php if ($entry['live_answer'] == 'Yes' || $entry['live_answer'] == 'Pass') { ?>
                      <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" />
                    <?php } elseif ($entry['live_answer'] == 'TBD') { ?>
                      <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg" alt="Minus mark">
                    <?php } else { ?>
                      <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg" alt="Minus mark" />
                    <?php } ?>
                  </div>
                  <div class="col-four">
                    <?php if ($entry['notes_63'] == null) { ?>
                      <p class="no-notes">N/A</p>
                    <?php } else { ?>
                      <p><?php echo $entry['notes_63'] ?></p>
                    <?php } ?>
                  </div>
                </div>
              </div> -->
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>New Client Growth</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>20 per FTE DVM/Mo</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['83'] == 'Yes' || $entry['83'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['83'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['182'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['182'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>New Client Average Annual Spend</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Above $575 per new client (Under $2.5 Million in Revenue).<br>
                                        Above $690 per new client (Over $2.5 Million in Revenue).<br>
                                        Average Spend by New Clients over past 12 months.</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['84'] == 'Yes' || $entry['84'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['84'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['183'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['183'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Percentage of Revenue from New Clients</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Between 15% to 25%</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['85'] == 'Yes' || $entry['85'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['85'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['184'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['184'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Category</p>
                                </div>
                                <div class="col-one">
                                    <p>Active Population Growth</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Active population growing over trailing 12 months.</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <?php if (is_page(88)) { ?>
                                    <?php if ($entry['318'] == 'Yes' || $entry['318'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['318'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                    <?php } else { ?>
                                    <?php if ($entry['317'] == 'Yes' || $entry['317'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['317'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-four">
                                    <?php if ($entry['319'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['319'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                <div class="row-inner no-border">
                  <div class="col-one">
                    <p>Client Retention</p>
                  </div>
                  <div class="col-two">
                    <p>Above 85%</p>
                  </div>
                  <div class="col-three">
                    <?php if ($entry['client_retention'] == 'Yes' || $entry['client_retention'] == 'Pass') { ?>
                      <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" />
                    <?php } elseif ($entry['client_retention'] == 'TBD') { ?>
                      <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg" alt="Minus mark">
                    <?php } else { ?>
                      <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg" alt="Minus mark" />
                    <?php } ?>
                  </div>
                  <div class="col-four">
                    <?php if ($entry['notes_67'] == null) { ?>
                      <p class="no-notes">N/A</p>
                    <?php } else { ?>
                      <p><?php echo $entry['notes_67'] ?></p>
                    <?php } ?>
                  </div>
                </div>
              </div> -->
                    <!-- </div> -->

                </div>
                <?php } ?>
                <?php if ($entry['88'] != null) { ?>
                <div class="scorecard-section" id="hr-section">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>HR & Training Scorecards</p>
                        </div>
                        <div class="report-btns">
                            <div class="toggle-btns">
                                <div class="toggle-cover"></div>
                                <i class="fas fa-arrow-left left-report-btn" id="hr-left"></i>
                                <p>Report <span class="report-number" id="hr-numbers">1</span> of 8</p>
                                <i class="fas fa-arrow-right right-report-btn" id="hr-right"></i>
                            </div>
                            <p class="view-all-btn" id="hr-all">View All</p>
                        </div>
                    </div>
                    <div class="report hr-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Performance Management</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>One evaluation structure performed annually with a focus on development</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['88'] == 'Yes' || $entry['88'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['88'] === 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['186'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['186'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Job Descriptions have responsibilities, requirements, culture, and signature</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['89'] == 'Yes' || $entry['89'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['89'] === 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['187'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['187'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Monthly one on one are conducted and documented with each employee</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['90'] == 'Yes' || $entry['90'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['90'] === 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['188'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['188'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Disciplinary structure is outlined in handbook and is enforced consistently</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['91'] == 'Yes' || $entry['91'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['91'] === 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['189'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['189'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report hr-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Supervisor Skills</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Supervisors possess the appropriate leadership skill level for their position</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['93'] == 'Yes' || $entry['93'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['93'] === 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['190'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['190'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Hospital provides annual or quarterly supervisor specific training</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['94'] == 'Yes' || $entry['94'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['94'] === 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['191'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['191'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Supervisors receive quarterly or semi-annual 360 evals</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['95'] == 'Yes' || $entry['95'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['95'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['192'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['192'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report hr-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Client Experience</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Client complaints do not reflect internal hospital issues</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['97'] == 'Yes' || $entry['97'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['97'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['193'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['193'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Hospital provides routine client experience training (at least EOM)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['98'] == 'Yes' || $entry['98'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['98'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['194'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['194'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report hr-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Employee Engagement</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Employee happiness score over 8</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['100'] == 'Yes' || $entry['100'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['100'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['195'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['195'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Hospital engages in routine team building activities (at least monthly)</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['101'] == 'Yes' || $entry['101'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['101'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['196'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['196'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report hr-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Culture</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Has mission, vision, and/or core behaviors, known by PO/ PM</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['103'] == 'Yes' || $entry['103'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['103'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['197'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['197'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Culture is discussed on a daily basis in the hospital</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['104'] == 'Yes' || $entry['104'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['104'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['198'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['198'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>All employee documentation is tied to practice culture</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['105'] == 'Yes' || $entry['105'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['105'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['199'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['199'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report hr-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Recruiting</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Background checks are performed on all candidates prior to hire</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['109'] == 'Yes' || $entry['109'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['109'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['200'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['200'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Interview questions are legal and job-specific</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['107'] == 'Yes' || $entry['107'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['107'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['201'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['201'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>References are checked for all final candidates prior to hire</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['108'] == 'Yes' || $entry['108'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['108'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['202'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['202'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report hr-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Legal Compliance</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Hospital has employee handbook, is up to date on current laws</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['111'] == 'Yes' || $entry['111'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['111'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['203'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['203'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Employees are classified properly</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['112'] == 'Yes' || $entry['112'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['112'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['204'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['204'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Hospital follows FLSA and equal pay laws</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['113'] == 'Yes' || $entry['113'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['113'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['205'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['205'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Appropriate legal posters are visible to employees</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['114'] == 'Yes' || $entry['114'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['114'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['206'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['206'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="report hr-report hidden-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">Training</h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-two">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-three">
                                    <p>Notes</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>New hire training program is effective and completed by all new hires</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['116'] == 'Yes' || $entry['116'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['116'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['207'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['207'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Ongoing training is provided to all employees at least monthly</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['117'] == 'Yes' || $entry['117'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['117'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['208'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['208'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Benchmark</p>
                                </div>
                                <div class="col-one">
                                    <p>Routine CE provided for all employees</p>
                                </div>
                                <div class="mobile-col">
                                    <p>Your Score</p>
                                </div>
                                <div class="col-two">
                                    <?php if ($entry['118'] == 'Yes' || $entry['118'] == 'Pass') { ?>
                                    <img class="check" src="/wp-content/uploads/2021/01/index-checkmark.svg"
                                        alt="Minus mark" />
                                    <?php } elseif ($entry['118'] == 'TBD') { ?>
                                    <img class="dash" src="/wp-content/uploads/2021/04/scorecard-yellow.svg"
                                        alt="Minus mark">
                                    <?php } else { ?>
                                    <img class="times" src="/wp-content/uploads/2021/01/scorecard-x.svg"
                                        alt="Minus mark" />
                                    <?php } ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Notes</p>
                                </div>
                                <div class="col-three">
                                    <?php if ($entry['209'] == null) { ?>
                                    <p class="no-notes">N/A</p>
                                    <?php } else { ?>
                                    <p>
                                        <?php echo $entry['209'] ?>
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <?php } ?>
                <div id="btp">
                    <a href="#poa-page" class="teal-btn" id="btp-btn">
                        <p>Back to top</p>
                        <i class="fas fa-caret-up"></i>
                    </a>
                </div>
            </div>
            <!-- SCOREDCARD END -->
            <!-- PLAN START -->
            <div id="plan-results" class="results hidden" style="display: none;">
                <div class="plan-section" id="practice-goals">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Practice Goals</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row" id="priority-row-one">
                            <div class="row-inner no-border">
                                <div class="goal-row">
                                    <div class="goal-number">1</div>
                                    <h2 class="report-title">
                                        <?php echo $entry['216'] ?>
                                    </h2>
                                </div>
                            </div>
                            <div class="row-inner no-border">
                                <div class="goal-row">
                                    <div class="goal-number">2</div>
                                    <h2 class="report-title">
                                        <?php echo $entry['217'] ?>
                                    </h2>
                                </div>
                            </div>
                            <div class="row-inner no-border">
                                <div class="goal-row">
                                    <div class="goal-number">3</div>
                                    <h2 class="report-title">
                                        <?php echo $entry['218'] ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="plan-section plan-hover">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['212'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['213'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['211.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['211.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['211.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['214'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['215'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="plan-section plan-hover">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['221'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['222'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['223.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['223.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['223.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['224'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['225'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="plan-section plan-hover">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['227'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['228'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['229.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['229.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['229.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['230'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['231'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($entry['287'] == 'Yes'): ?>
                <div class="plan-section plan-hover">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['233'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['234'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['235.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['235.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['235.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['236'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['237'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($entry['288'] == 'Yes'): ?>
                <div class="plan-section plan-hover">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['239'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['240'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['241.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['241.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['241.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['242'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['243'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($entry['289'] == 'Yes'): ?>
                <div class="plan-section plan-hover">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['245'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['246'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['247.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['247.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['247.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['248'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['249'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($entry['290'] == 'Yes'): ?>
                <div class="plan-section plan-hover">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['251'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['252'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['253.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['253.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['253.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['255'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['254'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($entry['291'] == 'Yes'): ?>
                <div class="plan-section plan-hover">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['295'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['296'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['297.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['297.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['297.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['299'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['300'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($entry['292'] == 'Yes'): ?>
                <div class="plan-section plan-hover">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['302'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['303'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['304.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['304.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['304.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['306'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['307'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($entry['293'] == 'Yes'): ?>
                <div class="plan-section plan-hover" id="last-plan">
                    <div class="top-bar">
                        <div class="orange-title">
                            <p>Priority/Objective</p>
                        </div>
                    </div>
                    <div class="report priority-report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <h2 class="report-title">
                                    <?php echo $entry['309'] ?>
                                </h2>
                            </div>
                        </div>
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Metric</p>
                                </div>
                                <div class="col-two">
                                    <p>Tools used</p>
                                </div>
                                <div class="col-three">
                                    <p>Accountability</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="mobile-col">
                                    <p>Metric</p>
                                </div>
                                <div class="col-one">
                                    <p>
                                        <?php echo $entry['310'] ?>
                                    </p>
                                </div>
                                <div class="mobile-col">
                                    <p>Tools Used</p>
                                </div>
                                <div class="col-two tools-used">
                                    <?php if ($entry['311.1'] == '1'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.1'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.2'] == '2'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.2'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.3'] == '3'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.3'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.4'] == '4'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.4'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.5'] == '5'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.5'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.6'] == '6'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.6'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.7'] == '7'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.7'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.8'] == '8'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.8'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.9'] == '9'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.9'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.11'] == '10'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.11'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.12'] == '11'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.12'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.13'] == '12'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.13'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.14'] == '13'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.14'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.15'] == '14'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.15'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.16'] == '15'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.16'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.17'] == '16'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.17'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.18'] == '17'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.18'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.19'] == '18'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.19'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.21'] == '19'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.21'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.22'] == '20'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.22'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.23'] == '21'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.23'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.24'] == '22'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.24'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.25'] == '23'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.25'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ($entry['311.26'] == '24'): ?>
                                    <div class="tool-used">
                                        <?php echo $entry['311.26'] ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mobile-col">
                                    <p>Accountability</p>
                                </div>
                                <div class="col-three">
                                    <p class="stakeholders"><span class="lowercase">i</span>VET360: <span
                                            class="sh-name">
                                            <?php echo $entry['313'] ?>
                                        </span></p>
                                    <p class="stakeholders">Practice: <span class="sh-name">
                                            <?php echo $entry['314'] ?>
                                        </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- PLAN END -->
        </div>
    </div>
    <!-- RESULTS END -->
    <div id="index-container" style="display: none;">
        <div id="index-inner">
            <div id="index-top-bar">
                <p id="index-title">Tool Index</p>
                <div id="index-btn" class="teal-btn">
                    <p>Open Index</p>
                    <i class="fas fa-caret-up"></i>
                </div>
            </div>
            <div id="index" style="max-height: 0;">
                <ul class="index-col">
                    <li class="index-item" data-id="1">1. ATC Analysis & Communication <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="2">2. Budgeting <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="3">3. Call Tracking & Training <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="4">4. Chart of Accounts Audit <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="5">5. Culture Assesment & Communication <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="6">6. Dashboard w/ Benchmarks <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                </ul>
                <ul class="index-col">
                    <li class="index-item" data-id="7">7. location Intelligence Report <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="8">8. Financial/Inventory Safeguarding <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="9">9. HR Protocol Database <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="10">10. Database Marketing <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="11">11. Marketing Plan <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="12">12. New Hire & Ongoing Training <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                </ul>
                <ul class="index-col">
                    <li class="index-item" data-id="13">13. Online Marketing Campaign(s) <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="14">14. Payroll & Wage Analysis <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="15">15. Pet Insurance <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="16">16. Cost of COGs Tracking Tool <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="17">17. Learningvet.com <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="18">18. Staff Survey <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                </ul>
                <ul class="index-col">
                    <li class="index-item" data-id="19">19. Social Media Knowledge Base <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="20">20. SWOT Analysis <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="21">21. Treatment Plans & Presentation <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="22">22. Variable Expense Review <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="23">23. Website Development/Management <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                    <li class="index-item" data-id="24">24. Optimized Reminder Platform <img class="check"
                            src="/wp-content/uploads/2021/01/index-checkmark.svg" alt="Minus mark" /></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
  return ob_get_clean();
}
add_shortcode('poa_results','poa_results');

add_filter("gform_field_value_uuid", "uuid");
function uuid($prefix = ''){
    $chars = md5(uniqid(mt_rand(), true));
    $uuid  = substr($chars,0,8) . '-';
    $uuid .= substr($chars,8,4) . '-';
    $uuid .= substr($chars,12,4) . '-';
    $uuid .= substr($chars,16,4) . '-';
    $uuid .= substr($chars,20,12);
    return $prefix . $uuid;
}

function marketing_plan_results() {
  ob_start();
  // if(isset($_GET['entry_id'])){
  //   $entry_id = $_GET['entry_id'];
  //   esc_html($entry_id);
  //
  //   $search_criteria = array(
  // 	'status' => 'active',
  // 	'field_filters' => array(
  // 	array( 'key' => '316', 'value' => $entry_id ),
  // 	),
  //   );
  //
  //   $entries = GFAPI::get_entries( 48, $search_criteria );
  //   $form = GFAPI::get_form( $entry_id );
  //   $entry = rgar( $entries, 0 );
  //   esc_html($entry);
  // }
  // echo $entry_id;
  // $leads = GFFormsModel::get_leads('48');
  if(isset($_GET['entry_id'])){
    $entry_id = $_GET['entry_id'];
    esc_html($entry_id);

    $search_criteria = array(
    'status' => 'active',
    'field_filters' => array(
    array( 'key' => '57', 'value' => $entry_id ),
    ),
    );

    $entries = GFAPI::get_entries( 24, $search_criteria );

    $entry = rgar( $entries, 0 );
    esc_html($entry);
  }
  ?>
<?php /* <pre><?php print_r($entry); ?>
</pre> */ ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js?version=<?= time() ?>"></script>

<div class="marketing-plan-header">
    <div class="marketing-plan-header-container max-width-inner">
        <h1>Marketing Plan</h1>
        <h3>
            <?php echo $entry['1'] ?>
        </h3>
    </div>
    <img src="/wp-content/uploads/2021/12/iVET360-website-divider-cloud-top.svg" alt="Divider">
</div>
<div class="marketing-plan-results">
    <div class="marketing-results-container max-width-inner">
        <div class="marketing-results-column marketing-results-left">
            <div class="results-box" id="practice-goals">
                <div class="results-box-top">
                    <p>Practice Goals</p>
                </div>
                <div class="results-box-bottom">
                    <ul>
                        <li><img src="/wp-content/uploads/2020/10/iVET-VMBR-icon-yes.svg" alt="Check">
                            <?php echo $entry['2'] ?>
                        </li>
                        <li><img src="/wp-content/uploads/2020/10/iVET-VMBR-icon-yes.svg" alt="Check">
                            <?php echo $entry['3'] ?>
                        </li>
                        <li><img src="/wp-content/uploads/2020/10/iVET-VMBR-icon-yes.svg" alt="Check">
                            <?php echo $entry['4'] ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="results-box" id="pie-graph">
                <div class="results-box-top">
                    <p>Budget Spend</p>
                    <p>Click Slice For Details</p>
                </div>

                <div class="results-box-bottom">
                    <div class="graph-container">
                        <canvas id="myChart" width="100%" height="400"></canvas>

                    </div>
                    <div class="pie-percentage">
                        <?php
                $total = 0;
                $pieces = 0;
              ?>
                        <?php if ($entry['9.1'] != null) {
                $total = (int)$total + (int)$entry['12'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['15.1'] != null) {
                $total = (int)$total + (int)$entry['16'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['18.1'] != null) {
                $total = (int)$total + (int)$entry['19'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['21.1'] != null) {
                $total = (int)$total + (int)$entry['22'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['24.1'] != null) {
                $total = (int)$total + (int)$entry['25'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['27.1'] != null) {
                $total = (int)$total + (int)$entry['28'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['30.1'] != null) {
                $total = (int)$total + (int)$entry['31'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php /* if ($entry['33.1'] != null) {
                $total = $total + $entry['34'];
                $pieces = $pieces + 1;
              } */ ?>
                        <?php if ($entry['36.1'] != null) {
                $total = (int)$total + (int)$entry['37'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['39.1'] != null) {
                $total = (int)$total + (int)$entry['40'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['42.1'] != null) {
                $total = (int)$total + (int)$entry['43'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['45'] === 'Yes') {
                $total = (int)$total + (int)$entry['47'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['49'] === 'Yes') {
                $total = (int)$total + (int)$entry['51'];
                $pieces = (int)$pieces + 1;
              } ?>
                        <?php if ($entry['53'] === 'Yes') {
                $total = (int)$total + (int)$entry['55'];
                $pieces = (int)$pieces + 1;
               } ?>
                        <?php if ($entry['9.1'] != null) {
                $ivet = (int)$entry['12'] / (int)$total * 100;
              ?>
                        <h2 class="ivet-data" data-raw="<?php echo $entry['12'] ?>">
                            <?php echo round($ivet, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['15.1'] != null) {
                $google = (int)$entry['16'] / (int)$total * 100;
              ?>
                        <h2 class="google-ads-data" data-raw="<?php echo $entry['16'] ?>">
                            <?php echo round($google, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['18.1'] != null) {
                $facebook = (int)$entry['19'] / (int)$total * 100;
              ?>
                        <h2 class="facebook-ads-data" data-raw="<?php echo $entry['19'] ?>">
                            <?php echo round($facebook, 2)?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['21.1'] != null) {
                $yelp = (int)$entry['22'] / (int)$total * 100;
              ?>
                        <h2 class="yelp-ads-data" data-raw="<?php echo $entry['22'] ?>">
                            <?php echo round($yelp, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['24.1'] != null) {
              $print = (int)$entry['25'] / (int)$total * 100;
            ?>
                        <h2 class="print-collateral-data" data-raw="<?php echo $entry['25'] ?>">
                            <?php echo round($print, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['27.1'] != null) {
              $press = (int)$entry['28'] / (int)$total * 100;
            ?>
                        <h2 class="press-data" data-raw="<?php echo $entry['28'] ?>">
                            <?php echo round($press, 2)?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['30.1'] != null) {
              $sponsorships = (int)$entry['31'] / (int)$total * 100;
            ?>
                        <h2 class="sponsorships-data" data-raw="<?php echo $entry['31'] ?>">
                            <?php echo round($sponsorships, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php /* if ($entry['33.1'] != null) {
              $events = $entry['34'] / $total * 100;
            ?>
                        <h2 class="events-data" data-raw="<?php echo $entry['34'] ?>">
                            <?php echo round($events, 2)?>%
                        </h2>
                        <?php } */ ?>
                        <?php if ($entry['36.1'] != null) {
              $promotional = (int)$entry['37'] / (int)$total * 100;
            ?>
                        <h2 class="promotional-items-data" data-raw="<?php echo $entry['37'] ?>">
                            <?php echo round($promotional, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['39.1'] != null) {
              $videography = (int)$entry['40'] / (int)$total * 100;
            ?>
                        <h2 class="videography-photography-data" data-raw="<?php echo $entry['40'] ?>">
                            <?php echo round($videography, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['42.1'] != null) {
              $reminder = (int)$entry['43'] / (int)$total * 100;
            ?>
                        <h2 class="reminder-platform-data" data-raw="<?php echo $entry['43'] ?>">
                            <?php echo round($reminder, 2)?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['45'] != null) {
              $customOne = (int)$entry['47'] / (int)$total * 100;
            ?>
                        <h2 class="custom-one-data" data-raw="<?php echo $entry['47'] ?>">
                            <?php echo round($customOne, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['49'] != null) {
              $customTwo = (int)$entry['51'] / (int)$total * 100;
            ?>
                        <h2 class="custom-two-data" data-raw="<?php echo $entry['51'] ?>">
                            <?php echo round($customTwo, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['53'] != null) {
              $customThree = (int)$entry['55'] / (int)$total * 100;
            ?>
                        <h2 class="custom-three-data" data-raw="<?php echo $entry['55'] ?>">
                            <?php echo round($customThree, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['58'] != null) {
              $customFour = (int)$entry['60'] / (int)$total * 100;
            ?>
                        <h2 class="custom-four-data" data-raw="<?php echo $entry['60'] ?>">
                            <?php echo round($customFour, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['62'] != null) {
              $customFive = (int)$entry['64'] / (int)$total * 100;
            ?>
                        <h2 class="custom-five-data" data-raw="<?php echo $entry['64'] ?>">
                            <?php echo round($customFive, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['66'] != null) {
              $customSix = (int)$entry['68'] / (int)$total * 100;
            ?>
                        <h2 class="custom-six-data" data-raw="<?php echo $entry['68'] ?>">
                            <?php echo round($customSix, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['70'] != null) {
              $customSeven = (int)$entry['72'] / (int)$total * 100;
            ?>
                        <h2 class="custom-seven-data" data-raw="<?php echo $entry['72'] ?>">
                            <?php echo round($customSeven, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['74'] != null) {
              $customEight = (int)$entry['76'] / (int)$total * 100;
            ?>
                        <h2 class="custom-eight-data" data-raw="<?php echo $entry['76'] ?>">
                            <?php echo round($customEight, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['78'] != null) {
              $customNine = (int)$entry['80'] / (int)$total * 100;
            ?>
                        <h2 class="custom-nine-data" data-raw="<?php echo $entry['80'] ?>">
                            <?php echo round($customNine, 2) ?>%
                        </h2>
                        <?php } ?>
                        <?php if ($entry['82'] != null) {
              $customTen = (int)$entry['84'] / (int)$total * 100;
            ?>
                        <h2 class="custom-10-data" data-raw="<?php echo $entry['84'] ?>">
                            <?php echo round($customTen, 2) ?>%
                        </h2>
                        <?php } ?>
                    </div>
                    <div class="pie-tool-cards">
                        <?php if ($entry['9.1'] != null) { ?>
                        <div class="marketing-tool-card ivet-data">
                            <h3>iVET360 Services</h3>
                            <p>
                                <?php echo $entry['14'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['15.1'] != null) { ?>
                        <div class="marketing-tool-card google-ads-data">
                            <h3>Google Ads</h3>
                            <p>
                                <?php echo $entry['17'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['18.1'] != null) { ?>
                        <div class="marketing-tool-card facebook-ads-data">
                            <h3>Facebook Ads</h3>
                            <p>
                                <?php echo $entry['20'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['21.1'] != null) { ?>
                        <div class="marketing-tool-card yelp-ads-data">
                            <h3>Yelp Ads</h3>
                            <p>
                                <?php echo $entry['23'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['24.1'] != null) { ?>
                        <div class="marketing-tool-card print-collateral-data">
                            <h3>Print Collateral</h3>
                            <p>
                                <?php echo $entry['26'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['27.1'] != null) { ?>
                        <div class="marketing-tool-card press-data">
                            <h3>Press</h3>
                            <p>
                                <?php echo $entry['29'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['30.1'] != null) { ?>
                        <div class="marketing-tool-card sponsorships-data">
                            <h3>Sponsorships & Events</h3>
                            <p>
                                <?php echo $entry['32'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php /* if ($entry['33.1'] != null) { ?>
                        <div class="marketing-tool-card events-data">
                            <h3>Events</h3>
                            <p>
                                <?php echo $entry['35'] ?>
                            </p>
                        </div>
                        <?php } */ ?>
                        <?php if ($entry['36.1'] != null) { ?>
                        <div class="marketing-tool-card promotional-items-data">
                            <h3>Promotional Items</h3>
                            <p>
                                <?php echo $entry['38'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['39.1'] != null) { ?>
                        <div class="marketing-tool-card videography-photography-data">
                            <h3>Videography/Photography</h3>
                            <p>
                                <?php echo $entry['41'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['42.1'] != null) { ?>
                        <div class="marketing-tool-card reminder-platform-data">
                            <h3>Reminder Platform</h3>
                            <p>
                                <?php echo $entry['44'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['45'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-one-data">
                            <h3>
                                <?php echo $entry['46'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['48'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['49'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-two-data">
                            <h3>
                                <?php echo $entry['50'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['52'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['53'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-three-data">
                            <h3>
                                <?php echo $entry['54'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['56'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['58'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-four-data">
                            <h3>
                                <?php echo $entry['59'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['61'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['62'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-five-data">
                            <h3>
                                <?php echo $entry['63'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['65'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['66'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-six-data">
                            <h3>
                                <?php echo $entry['67'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['68'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['70'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-seven-data">
                            <h3>
                                <?php echo $entry['71'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['73'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['74'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-eight-data">
                            <h3>
                                <?php echo $entry['75'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['77'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['78'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-nine-data">
                            <h3>
                                <?php echo $entry['79'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['81'] ?>
                            </p>
                        </div>
                        <?php } ?>
                        <?php if ($entry['82'] === 'Yes') { ?>
                        <div class="marketing-tool-card custom-ten-data">
                            <h3>
                                <?php echo $entry['83'] ?>
                            </h3>
                            <p>
                                <?php echo $entry['85'] ?>
                            </p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="marketing-results-column marketing-results-right">
            <div class="results-box" id="marketing-budget">
                <div class="results-box-top">
                    <p>Marketing Budget</p>
                </div>
                <div class="results-box-bottom">
                    <div class="budget-box-left">
                        <ul>
                            <?php if ($entry['7.1'] != null) {
                  $one = .01 * (int)$entry['6'];
                  ?>
                            <li>
                                <div class="budget-percentage">
                                    <p>
                                        <?php echo $entry['7.1'] ?>
                                    </p>
                                </div> $
                                <?php echo number_format($one) ?>
                            </li>
                            <?php } ?>
                            <?php if ($entry['7.2'] != null) {
                  $two = .02 * (int)$entry['6'];
                  ?>
                            <li>
                                <div class="budget-percentage">
                                    <p>
                                        <?php echo $entry['7.2'] ?>
                                    </p>
                                </div> $
                                <?php echo number_format($two) ?>
                            </li>
                            <?php } ?>
                            <?php if ($entry['7.3'] != null) {
                  $three = .03 * (int)$entry['6'];
                  ?>
                            <li>
                                <div class="budget-percentage">
                                    <p>
                                        <?php echo $entry['7.3'] ?>
                                    </p>
                                </div> $
                                <?php echo number_format($three) ?>
                            </li>
                            <?php } ?>
                            <?php if ($entry['7.4'] != null) {
                  $four = .04 * (int)$entry['6'];
                  ?>
                            <li>
                                <div class="budget-percentage">
                                    <p>
                                        <?php echo $entry['7.4'] ?>
                                    </p>
                                </div> $
                                <?php echo number_format($four) ?>
                            </li>
                            <?php } ?>
                            <?php if ($entry['7.5'] != null) {
                  $five = .05 * (int)$entry['6'];
                  ?>
                            <li>
                                <div class="budget-percentage">
                                    <p>
                                        <?php echo $entry['7.5'] ?>
                                    </p>
                                </div> $
                                <?php echo number_format($five) ?>
                            </li>
                            <?php } ?>
                            <?php if ($entry['7.6'] != null) {
                  $ten = .1 * (int)$entry['6'];
                  ?>
                            <li>
                                <div class="budget-percentage">
                                    <p>
                                        <?php echo $entry['7.6'] ?>
                                    </p>
                                </div> $
                                <?php echo number_format($ten) ?>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="budget-box-right">
                        <h3>Your Revenue: $
                            <?php echo number_format($entry['6']) ?>
                        </h3>
                        <p>Our goal is to develop the most cost effective marketing plan while still achieving your
                            hospital marketing goals. To get a better understanding of a traditionally healthy marketing
                            spend, we look to have marketing costs account for roughly 1%-5% of total revenue. The
                            revenue figure abovel is your accumulated trailing twelve months of revenue.</p>
                    </div>
                </div>
            </div>
            <div class="results-box" id="marketing-tools">
                <div class="results-box-top">
                    <p>Marketing Tools</p>
                </div>

                <div class="tools-subtitle">
                    <h3>Additional Marketing Tools</h3>
                </div>
                <div class="results-box-bottom">
                    <?php  if ($entry['9.1'] != null) { ?>
                    <!-- <div class="marketing-tool-card ivet-data">
                <h3>iVET360 Services</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
              </div> -->
                    <div class="tools-list marketing-tool-card">
                        <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-website.svg" alt="Website & SEO Management">
                            Website & SEO Management</h3>
                        <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-design.svg" alt="Unlimited Design & Content">
                            Creative Services</h3>
                        <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-marketing-manager.svg"
                                alt="Dedicated Marketing Manager"> Dedicated Marketing Manager</h3>
                        <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-reputation.svg" alt="Reputation Management">
                            Reputation Management</h3>
                        <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-pulse.svg" alt="Pulse Dashboard"> Pulse
                            Dashboard</h3>
                        <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-local-listing.svg"
                                alt="Local Listing Management"> Local Listing Management</h3>
                        <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-call-tracking.svg"
                                alt="Call Tracking Services"> Call Tracking Services</h3>
                        <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-newsletters.svg"
                                alt="Promotional Newsletters"> Promotional Newsletters</h3>
                    </div>
                    <?php }  ?>
                    <?php if ($entry['15.1'] != null) { ?>
                    <div class="marketing-tool-card google-ads-data">
                        <h3>Google Ads</h3>
                        <p>High adoption rates during the pandemic may have substantially increased your new client
                            numbers, but keeping yourself in front of your clients and at the top of search engine
                            results is an investment in the continuing financial health of your practice. Hospitals that
                            utilize Google Ads saw a 5% increase in the number of reviews over those that did not. For
                            iVET360 clients in particular, Google Ads are currently the leading contributor to new
                            client generation.</p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['18.1'] != null) { ?>
                    <div class="marketing-tool-card facebook-ads-data">
                        <h3>Facebook Ads</h3>
                        <p>Facebook Ads and boosted posts can be a valuable awareness generation tool for your practice.
                            While conversions through Facebook are lower than we see with Google, this is an excellent
                            promotional opportunity for new practices as well as established practices aiming to develop
                            more community awareness around their brand. Boosted posts also serve as a means of
                            increasing the visibility of special offers, and they also help to get your content in front
                            of more of your followers.</p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['21.1'] != null) { ?>
                    <div class="marketing-tool-card yelp-ads-data">
                        <h3>Yelp Ads</h3>
                        <p>According to our data, Yelp Ads are the least effective paid lead generation tool utilized by
                            veterinary practices. We do not generally recommend allocating marketing funds to Yelp Ads,
                            as those dollars are better spent elsewhere such as Google Ads (where the average ROI for
                            our practices is 7x the annual investment). However, if you are currently in contract with
                            Yelp for ads, that dollar amount will be represented here in your marketing plan. </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['24.1'] != null) { ?>
                    <div class="marketing-tool-card print-collateral-data">
                        <h3>Print Collateral</h3>
                        <p>Although the prevalence of print collateral is now waning as many hospitals transition to
                            digital-first marketing efforts, there are still many instances in which print collateral is
                            an appropriate investment. This category encompasses a wide variety of print materials, such
                            as business cards, brochures, rack cards, flyers, handouts, folders, banners, posters,
                            wayfinding signage and more. While design services are included as part of your service with
                            iVET360, the cost of production is an additional expense to the hospital that should be
                            reflected in your overall marketing budget. Hospitals that have recently rebranded, or those
                            that have outdated materials, are likely to see a larger portion of their budget allocated
                            to print collateral production. </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['27.1'] != null) { ?>
                    <div class="marketing-tool-card press-data">
                        <h3>Press</h3>
                        <p>This category represents traditional print ads, such as ads for a local paper or program and
                            digital ads placed with an online magazine. While some of these initiatives may be
                            reciprocal and as such unpaid, there is typically an investment associated with the
                            placement of ads of this type. As with print collateral, iVET360 will design your ad at no
                            additional cost, however the cost to place the ad is an additional expense to the practice.
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['30.1'] != null) { ?>
                    <div class="marketing-tool-card sponsorships-data">
                        <h3>Sponsorships & Events</h3>
                        <p>For many hospitals, sponsorships are the key to enhanced community involvement. Sponsoring
                            local events, charities and fundraisers can help to establish a hospital within its
                            community and increase overall brand awareness. As with sponsorships, participation in such
                            events can also elevate the hospital within its community. While sponsoring an event
                            generally comes with a monetary donation of sorts, event participation comes with the
                            additional cost for materials such as tents, special promotional items, and more. This
                            estimate captures these costs.</p>
                    </div>
                    <?php } ?>
                    <?php /* if ($entry['33.1'] != null) { ?>
                    <div class="marketing-tool-card events-data">
                        <h3>Events</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <?php } */ ?>
                    <?php if ($entry['36.1'] != null) { ?>
                    <div class="marketing-tool-card promotional-items-data">
                        <h3>Promotional Items</h3>
                        <p>Promotional items can go a long way toward enhancing your customer experience. It is
                            important to choose items that are useful and impactful, as the cost of promotional items
                            can quickly obliterate your budget. Examples of common and effective promotional items
                            include: bandanas, frisbees, collapsible water dishes, pet waste bags, leashes.</p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['39.1'] != null) { ?>
                    <div class="marketing-tool-card videography-photography-data">
                        <h3>Videography/Photography</h3>
                        <p>While it can be expensive, custom videography and photography can have a hugely beneficial
                            impact on your practice's overall marketing presence. In addition to representing your
                            hospital even more authentically, photography and videography offers potential clients a
                            glimpse into what their experience might be like.</p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['42.1'] != null) { ?>
                    <div class="marketing-tool-card reminder-platform-data">
                        <h3>Reminder Platform</h3>
                        <p>Reminder platforms make it easier than ever to improve client compliance, and many also come
                            with an app that allows clients to manage their pet's care right from their phone. Platforms
                            like PetDesk and AllyDVM have become the rule, rather than the exception. If your practice
                            doesn't have a reminder platform currently, it's time to consider this investment as a means
                            of enhancing overall retention and compliance. </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['45'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-one-data">
                        <h3>
                            <?php echo $entry['46'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['48'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['49'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-two-data">
                        <h3>
                            <?php echo $entry['50'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['52'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['53'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-three-data">
                        <h3>
                            <?php echo $entry['54'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['56'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['58'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-four-data">
                        <h3>
                            <?php echo $entry['59'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['61'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['62'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-five-data">
                        <h3>
                            <?php echo $entry['63'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['65'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['66'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-six-data">
                        <h3>
                            <?php echo $entry['67'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['68'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['70'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-seven-data">
                        <h3>
                            <?php echo $entry['71'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['73'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['74'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-eight-data">
                        <h3>
                            <?php echo $entry['75'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['77'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['78'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-nine-data">
                        <h3>
                            <?php echo $entry['79'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['81'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <?php if ($entry['82'] === 'Yes') { ?>
                    <div class="marketing-tool-card custom-ten-data">
                        <h3>
                            <?php echo $entry['83'] ?>
                        </h3>
                        <p>
                            <?php echo $entry['85'] ?>
                        </p>
                    </div>
                    <?php } ?>
                </div>
                <!-- <div class="tools-subtitle">
            <h3>included in your marketing spend</h3>
          </div> -->
                <!-- <div class="tools-list">
            <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-website.svg" alt="Website & SEO Management"> Website & SEO Management</h3>
            <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-design.svg" alt="Unlimited Design & Content"> Creative Services</h3>
            <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-marketing-manager.svg" alt="Dedicated Marketing Manager"> Dedicated Marketing Manager</h3>
            <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-reputation.svg" alt="Reputation Management"> Reputation Management</h3>
            <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-pulse.svg" alt="Pulse Dashboard"> Pulse Dashboard</h3>
            <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-local-listing.svg" alt="Local Listing Management"> Local Listing Management</h3>
            <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-call-tracking.svg" alt="Call Tracking Services"> Call Tracking Services</h3>
            <h3><img src="/wp-content/uploads/2021/12/MKT-PLN-newsletters.svg" alt="Promotional Newsletters"> Promotional Newsletters</h3>
          </div> -->
            </div>
        </div>




    </div>
</div>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

<?php return ob_get_clean();
}
add_shortcode('marketing_plan_results','marketing_plan_results');


function employer_scorecard_results() {
  ob_start();
  if(isset($_GET['entry_id'])){
	  $entry_id = $_GET['entry_id'];
	  esc_html($entry_id);
	  if(strlen($entry_id) == 2){
		   //old entry id
		   $entry = GFAPI::get_entry( $entry_id );
           esc_html($entry);
		  
	  }else{
           //new unique id
		  $search_criteria = array(
        'status' => 'active',
        'field_filters' => array(
          array( 'key' => '2', 'value' => $entry_id ),
          ),
		  );

      $form = '17';

		  $entries = GFAPI::get_entries( $form, $search_criteria );

		  $entry = rgar( $entries, 0 );
		  esc_html($entry);
	  }
  }
  ?>

<!-- <script type='text/javascript'>
let res = <?php echo json_encode($entry) ?>;
console.log(res);
</script> -->

<!-- <div id="res" style="width: 100vw;">
    <pre><?php print_r($entry); ?></pre>
</div> -->


<?php 
      $sub1 = 0;
      $sub2 = 0;
      $sub3 = 0;
      $sub4 = 0;
      $sub5 = 0;
      $sub6 = 0;
      $sub7 = 0;
      $sub8 = 0;
      $sub9 = 0;
      $sub10 = 0;
      $total = 0;

  // business listings
    if ($entry['4'] == "Claimed Profile") {
      $sub1 += 3;
    } elseif ($entry['4'] == "Unclaimed Profile") {
      $sub1 += 1;
    } else {
      $sub1;
    }
    
    if ($entry['6'] == "Claimed Profile") {
      $sub1 += 3;
    } elseif ($entry['6'] == "Unclaimed Profile") {
      $sub1 += 1;
    } else{
      $sub1;
    }

    if ($entry['7'] == "Always") {
      $sub1 += 2;
    } elseif ($entry['7'] == "Sometimes") {
      $sub1 += 1;
    } else{
      $sub1;
    }

  // reputation
    if ($entry['9'] == "Careers Page Highlights Culture & Benefits") {
      $sub2 += 3;
    } elseif ($entry['9'] == "Careers Page Only Lists Current Openings") {
      $sub2 += 1;
    } else {
      $sub2;
    }

    if ($entry['10'] == "Above 4.7") {
      $sub2 += 3;
    } elseif ($entry['10'] == "4.2 - 4.7") {
      $sub2 += 2;
    } elseif ($entry['10'] == "3.5 - 4.2") {
      $sub2 += 1;
    } else {
      $sub2;
    }

    if ($entry['11'] == "Above 4.5") {
      $sub2 += 3;
    } elseif ($entry['11'] == "4 - 4.5") {
      $sub2 += 2;
    } elseif ($entry['11'] == "3 - 4") {
      $sub2 += 1;
    } else {
      $sub2;
    }

    if ($entry['12'] == "Above 4.5") {
      $sub2 += 3;
    } elseif ($entry['12'] == "4 - 4.5") {
      $sub2 += 2;
    } elseif ($entry['12'] == "3 - 4") {
      $sub2 += 1;
    } else {
      $sub2;
    }

    // benefits 


    if ($entry['14'] == "3 weeks includes leave") {
      $sub3 += 3;
    } elseif ($entry['14'] == "> 2 weeks" ) {
      $sub3 += 2;
    } elseif ($entry['14'] == "< 2 weeks") {
      $sub3 += 1;
    } else {
      $sub3;
    }

    if ($entry['15'] == "Yes") {
      $sub3 += 2;
    } else {
      $sub3;
    }

    if ($entry['16'] == "> 1 week") {
      $sub3 += 3;
    } elseif ($entry['16'] == "1 week") {
      $sub3 += 2;
    } elseif ($entry['16'] == "< 1 week") {
      $sub3 += 1;
    } else {
      $sub3;
    }

    if ($entry['17'] == "> 50%") {
      $sub3 += 3;
    } elseif ($entry['17'] == "< 50%") {
      $sub3 += 1;
    } else {
      $sub3;
    }

    if ($entry['18'] == "> 50%") {
      $sub3 += 3;
    } elseif ($entry['18'] == "< 50%") {
      $sub3 += 1;
    } else {
      $sub3;
    }

    // compensation
    if ($entry['20'] == "Yes") {
      $sub4 += 5;
    } else {
      $sub4;
    }

    if ($entry['21'] == ">90th") {
      $sub4 += 4;
    } elseif ($entry['21'] == "75th - 90th") {
      $sub4 += 2;
    } elseif ($entry['21'] == "50th - 75th") {
      $sub4 += 1;
    } else {
      $sub4;
    }

    // recognition

    if ($entry['23'] ==  "Monthly/Planned") {
      $sub5 += 5;
    } elseif ($entry['23'] ==  "Quarterly/Planned") {
      $sub5 += 3;
    } else {
      $sub5++;
    }

    if ($entry['79'] ==  "Yes") {
      $sub5 += 2;
    } else {
      $sub5;
    }


    // work life balance 25-27, 81
    if ($entry['25'] ==  "Yes") {
      $sub6 += 3;
    } else {
      $sub6;
    }

    if ($entry['26'] ==  "Almost Always") {
      $sub6 += 4;
    } elseif ($entry['26'] ==  "Occasionally") {
      $sub6 += 2;
    } elseif ($entry['26'] ==  "Rarely") {
      $sub6 += 1;
    } else {
      $sub6;
    }

    if ($entry['27'] ==  "Almost Always") {
      $sub6 += 4;
    } elseif ($entry['27'] ==  "Sometimes") {
      $sub6 += 2;
    } elseif ($entry['27'] ==  "Rarely") {
      $sub6 += 1;
    } else {
      $sub6;
    }

    if ($entry['81'] ==  ">90% of the time") {
      $sub6 += 3;
    } elseif ($entry['81'] ==  "50% to 90% of the time") {
      $sub6 += 1;
    } else {
      $sub6;
    }


    // Leadership
    if ($entry['29'] ==  "Yes") {
      $sub7 += 5;
    } else {
      $sub7;
    }

    if ($entry['30'] ==  "Yes") {
      $sub7 += 5;
    } else {
      $sub7;
    }

    if ($entry['31'] ==  "Yes") {
      $sub7 += 5;
    } else {
      $sub7;
    }

    if ($entry['83'] ==  "Yes") {
      $sub7 += 2;
    } else {
      $sub7;
    }

    
    // Turnover

     if ($entry['33'] == "< 10%" ) {
      $sub8 += 4;
     } elseif ($entry['33'] == "10%-30%" ) {
      $sub8 += 2;
     } else {
      $sub8;
     }

     if ($entry['38'] ==  "Always") {
      $sub8 += 5;
    } elseif ($entry['38'] ==  "Sometimes") {
      $sub8 += 3;
    } else {
      $sub8;
    }

    if ($entry['46'] ==  "Always") {
      $sub8 += 5;
    } elseif ($entry['46'] ==  "Sometimes") {
      $sub8 += 3;
    } else {
      $sub8;
    }

    if ($entry['85'] ==  "Yes, saved and analyzed routinely") {
      $sub8 += 2;
    } elseif ($entry['85'] ==  "Saved, but not routinely analyzed") {
      $sub8 += 1;
    } else {
      $sub8;
    }

    //  Employee survey
    if ($entry['35'] == "Yearly" ) {
      $sub9 += 5;
     } elseif ($entry['35'] == "As Needed"  ) {
      $sub9 += 3;
     } elseif ($entry['35']== "Once"  ) {
      $sub9 += 2;
     } else {
      $sub9;
     }

     if ($entry['36'] == "Yes" ) {
      $sub9 += 5;
     } elseif ($entry['36'] == "Not Formally"  ) {
      $sub9 += 3;
     } else {
      $sub9;
     }

    // training
    if ($entry['40'] ==  "Structured Training Plan") {
      $sub10 += 5;
    } elseif ($entry['40'] ==  "Unstructured Training") {
      $sub10 += 3;
    } else {
      $sub10;
    }

    if ($entry['41'] ==  "Routine Check-ins") {
      $sub10 += 5;
    } elseif ($entry['41'] ==  "Occasional Check-ins") {
      $sub10 += 3;
    } elseif ($entry['41'] ==  "Check-in If Needed") {
      $sub10 += 2;
    } else {
      $sub10;
    }

    if ($entry['42'] ==  "Always") {
      $sub10 += 3;
    } elseif ($entry['42'] ==  "Depends") {
      $sub10 += 1;
    } else {
      $sub10;
    }

    if ($entry['43'] ==  "All Employees") {
      $sub10 += 5;
    } elseif ($entry['43'] ==  "For Some Employees") {
      $sub10 += 3;
    } else {
      $sub10;
    }


    if ($entry['44'] == "Everyone") {
      $sub10 += 3;
    } elseif ($entry['44'] ==  "Vets and Techs") {
      $sub10 += 2;
    } elseif ($entry['44'] ==  "Vets Only") {
      $sub10 += 1;
    } else {
      $sub10;
    }

    if ($entry['45'] ==  "Frequently") {
      $sub10 += 3;
    } elseif ($entry['45'] ==  "Routinely") {
      $sub10 += 2;
    } elseif ($entry['45'] ==  "Ocassionally") {
      $sub10 += 1;
    } else {
      $sub10;
    }

    $total = $sub1 + $sub2 + $sub3 + $sub4 + $sub5 + $sub6 + $sub7 + $sub8 + $sub9 + $sub10;
    $percentage = round(($total / 131) * 100);
   ?>

<div class="recession-page" id="recession-report">
    <!-- HERO START -->
    <div class="hero-outer">
        <div class="hero-inner">
            <div id="hero-text">
                <h1 class="heading-text"><span class="small-text">Employer of Choice</span><br>Scorecards</h1>
                <div class="clinic-name">
                    <?php echo $entry['1'] ?>
                </div>
                <div class="hidden-score clinic-name">Business Listing Score:
                    <?php echo $sub1 ?>
                </div>
                <div class="hidden-score clinic-name">Brand Reputation Score:
                    <?php echo $sub2 ?>
                </div>
                <div class="hidden-score clinic-name">Benefits Score:
                    <?php echo $sub3 ?>
                </div>
                <div class="hidden-score clinic-name">Compensation Score:
                    <?php echo $sub4 ?>
                </div>
                <div class="hidden-score clinic-name">Recognition Score:
                    <?php echo $sub5 ?>
                </div>
                <div class="hidden-score clinic-name">Work-Life Balance Score:
                    <?php echo $sub6 ?>
                </div>
                <div class="hidden-score clinic-name">Leadership Score:
                    <?php echo $sub7 ?>
                </div>
                <div class="hidden-score clinic-name">Turnover Score:
                    <?php echo $sub8 ?>
                </div>
                <div class="hidden-score clinic-name">Employee Engagement Score:
                    <?php echo $sub9 ?>
                </div>
                <div class="hidden-score clinic-name">Training Score:
                    <?php echo $sub10 ?>
                </div>
                <div class="clinic-name hidden-score">
                    <?php echo $total ?>/121 |
                    <?php echo $percentage ?>%
                </div>

            </div>
        </div>
    </div>
    <!-- HERO END -->
    <!-- RESULTS START -->
    <div id="results-outer">
        <div id="results-inner">
            <!-- business listings -->
            <div id="scorecard-results-1" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="report-title">
                                    <h2>Business Listings</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>While not a direct recruitment tool, well-curated business listings are
                                                essential for a veterinary hospital. Think of business listings as your
                                                hospital's online handshake. While they're great for telling people
                                                about your services, they also give potential hires a first impression
                                                of your work culture. A polished listing doesn't just attract customers;
                                                it also catches the eye of job seekers who fit your team's vibe.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-details">
                                    <?php if ($sub1 >= 6) { ?>
                                    <div class="circle green">
                                        <?php echo $sub1 ?> / 8
                                    </div>
                                    <?php } elseif($sub1 < 6 && $sub1 >= 4)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub1 ?> / 8
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub1 ?> / 8
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Indeed (or Similar Ad Site)</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Claimed Profile</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['4'] == "Claimed Profile" ) { ?>
                                        <div class="green circle">
                                            <?php echo $entry['4'] ?>
                                        </div>
                                        <?php } elseif ($entry['4'] == "Unclaimed Profile" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['4'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['4'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['47'] != null) { ?>
                                        <p>
                                            <?php echo $entry['47'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['4'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Glassdoor</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Claimed Profile</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['6'] == "Claimed Profile" ) { ?>
                                        <div class="green circle">
                                            <?php echo $entry['6'] ?>
                                        </div>
                                        <?php } elseif ($entry['6'] == "Unclaimed Profile" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['6'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['6'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['48'] != null) { ?>
                                        <p>
                                            <?php echo $entry['48'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['6'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->

                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- business listings -->
            <!-- brand reputation -->
            <div id="scorecard-results-2" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="report-title">
                                    <h2>Brand Reputation</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>Having a good name matters. When people hear that you're a top-notch
                                                veterinary hospital, you're more likely to attract staff who care deeply
                                                about their work and their patients. After all, who doesn't want to be
                                                part of a winning team?</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="report-details">
                                    <?php if ($sub2 >= 9) { ?>
                                    <div class="circle green">
                                        <?php echo $sub2 ?> / 12
                                    </div>
                                    <?php } elseif (($sub2 < 9) && ($sub2 >= 6))  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub2 ?> / 12
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub2 ?> / 12
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Careers Page</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>The careers page highlights benefits, culture, and why you would be a great
                                            place to work.</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['9'] == "Careers Page Highlights Culture & Benefits" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['9'] ?>
                                        </div>
                                        <?php } elseif ($entry['9'] == "Careers Page Only Lists Current Openings" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['9'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['9'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['50'] != null) { ?>
                                        <p>
                                            <?php echo $entry['50'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['9'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Google Reviews</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>>4.7/5</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['10'] == "Above 4.7" ) {?>
                                        <div class="green circle">Rating above 4.7</div>
                                        <?php } elseif ($entry['10'] == "4.2 - 4.7" ) {?>
                                        <div class="yellow circle">Rating between 4.2-4.7</div>
                                        <?php } elseif ($entry['10'] == "3.5 - 4.2" ) {?>
                                        <div class="yellow circle">Rating between 3.5-4.2</div>
                                        <?php } elseif ($entry['10'] == "Below 3.5" ) {?>
                                        <div class="red circle">Rating below 3.5</div>
                                        <?php } else { ?>
                                        <div class="red circle">N/A or No Reviews</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['51'] != null) { ?>
                                        <p>
                                            <?php echo $entry['51'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['10'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Glassdoor Reviews</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>>4.5/5</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['12'] == "Above 4.5" ) {?>
                                        <div class="green circle">Rating above 4.5</div>
                                        <?php } elseif ($entry['12'] == "4 - 4.5" ) {?>
                                        <div class="yellow circle">Rating between 4-4.5</div>
                                        <?php } elseif ($entry['12'] == "3 - 4" ) {?>
                                        <div class="yellow circle">Rating between 3-4</div>
                                        <?php } elseif ($entry['12'] == "Below 3" ) {?>
                                        <div class="red circle">Rating below 3</div>
                                        <?php } else {?>
                                        <div class="red circle">N/A or No Reviews</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['52'] != null) { ?>
                                        <p>
                                            <?php echo $entry['52'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['12'] ?>
                                        </p>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <?php if ($entry['1'] != null) { ?>
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Indeed Reviews</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>>4.5/5</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['11'] == "Above 4.5" ) {?>
                                        <div class="green circle">Rating above 4.5</div>
                                        <?php } elseif ($entry['11'] == "4 - 4.5" ) {?>
                                        <div class="yellow circle">Rating between 4-4.5</div>
                                        <?php } elseif ($entry['11'] == "3 - 4" ) {?>
                                        <div class="yellow circle">Rating between 3-4</div>
                                        <?php } elseif ($entry['11'] == "Below 3" ) {?>
                                        <div class="red circle">Rating below 3</div>
                                        <?php } else {?>
                                        <div class="red circle">N/A or No Reviews</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['53'] != null) { ?>
                                        <p>
                                            <?php echo $entry['53'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['11'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- brand reputation -->
            <!-- benefits -->
            <div id="scorecard-results-3" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="report-title">
                                    <h2 class="report-title">Benefits</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>Offering comprehensive benefits is a game-changer for hiring and
                                                retention. Offering things like solid health insurance and growth
                                                opportunities shows you care about your staff's well-being. Offering
                                                such benefits not only attracts top-tier candidates but also encourages
                                                existing staff to stay, fostering loyalty and reducing turnover.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-details">
                                    <?php if ($sub3 >= 11) { ?>
                                    <div class="circle green">
                                        <?php echo $sub3 ?> / 14
                                    </div>
                                    <?php } elseif (($sub3 < 11) && ($sub3 >= 7))  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub3 ?> / 14
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub3 ?> / 14
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- first row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>PTO/Vacation</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>At least 2 weeks with earnings starting by 90 days of employment.</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['14'] == "3 weeks includes leave" ) {?>
                                        <div class="green circle">3 or more weeks of PTO</div>
                                        <?php } elseif ($entry['14'] == "> 2 weeks" ) {?>
                                        <div class="yellow circle">2-3 weeks of PTO</div>
                                        <?php } elseif ($entry['14'] == "< 2 weeks" ) {?>
                                        <div class="yellow circle">Under 2 weeks of PTO</div>
                                        <?php } else {?>
                                        <div class="red circle">No PTO</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['54'] != null) { ?>
                                        <p>
                                            <?php echo $entry['54'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['14'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <?php if ($entry['1'] != null) {?>
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Increasing PTO</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>PTO increases with tenure</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['15'] == "Yes") {?>
                                        <div class="green circle">PTO increases with tenure</div>
                                        <?php } else {?>
                                        <div class="red circle">PTO does not increase</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['55'] != null) { ?>
                                        <p>
                                            <?php echo $entry['55'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['15'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- row -->
                            <?php if ($entry['14'] != null) {?>
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Sick Leave</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>At least 1 week</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['16'] == "> 1 week") {?>
                                        <div class="green circle">More than 1 week</div>
                                        <?php } elseif ($entry['16'] == "1 week" ) {?>
                                        <div class="yellow circle">Exactly 1 week</div>
                                        <?php } elseif ($entry['16'] == "< 1 week" ) {?>
                                        <div class="yellow circle">Less than 1 week</div>
                                        <?php } else {?>
                                        <div class="red circle">No sick leave</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['56'] != null) { ?>
                                        <p>
                                            <?php echo $entry['56'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['16'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Medical Insurance</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Pay > 50% of the premium</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['17'] == "> 50%" ) {?>
                                        <div class="green circle">More than 50% covered</div>
                                        <?php } elseif ($entry['17'] == "< 50%" ) {?>
                                        <div class="yellow circle">Less than 50% covered</div>
                                        <?php } else {?>
                                        <div class="red circle">No Medical Insurance offered</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['57'] != null) { ?>
                                        <p>
                                            <?php echo $entry['57'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['17'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Dental Insurance</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Pay > 50% of the premium</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['18'] == "> 50%" ) {?>
                                        <div class="green circle">More than 50% covered</div>
                                        <?php } elseif ($entry['18'] == "< 50%" ) {?>
                                        <div class="yellow circle">Less than 50% covered</div>
                                        <?php } else {?>
                                        <div class="red circle">No Dental Insurance offered</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['58'] != null) { ?>
                                        <p>
                                            <?php echo $entry['58'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['18'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- benefits -->
            <!-- compensation -->
            <div id="scorecard-results-4" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="report-title">
                                    <h2 class="report-title">Compensation</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>A competitive salary shows you value your team's skills and hard work,
                                                which in turn helps you attract and keep the best in the business.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- <h2 class="report-title">Compensation</h2> -->

                                <div class="report-details">
                                    <?php if ($sub4 >= 7) { ?>
                                    <div class="circle green">
                                        <?php echo $sub4 ?> / 9
                                    </div>
                                    <?php } elseif($sub4 < 7 && $sub4 > 4)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub4 ?> / 9
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub4 ?> / 9
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- first row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Wage Analysis</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Compensation reviewed annually</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['20'] == "Yes" ) {?>
                                        <div class="green circle">Reviewed Annually</div>
                                        <?php } else {?>
                                        <div class="red circle">Not Reviewed Annually</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['59'] != null) { ?>
                                        <p>
                                            <?php echo $entry['59'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['20'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Competitive Wages</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Pay is at or above 50th Percentile For Region</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['21'] == ">90th" ) {?>
                                        <div class="green circle">Above 90th Percentile</div>
                                        <?php } elseif ($entry['21'] == "75th - 90th" ) {?>
                                        <div class="yellow circle">Between 75th and 90th Percentile</div>
                                        <?php } elseif ($entry['21'] == "50th - 75th" ) {?>
                                        <div class="yellow circle">Between 50th and 75th Percentile</div>
                                        <?php } else {?>
                                        <div class="red circle">Below 50th Percentile</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['60'] != null) { ?>
                                        <p>
                                            <?php echo $entry['60'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['21'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Pay Transparency</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Pay range listed for all ads</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['7'] == "Always" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['7'] ?>
                                        </div>
                                        <?php } elseif ($entry['7'] == "Sometimes" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['7'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['7'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['49'] != null) { ?>
                                        <p>
                                            <?php echo $entry['49'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['7'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- compensation -->
            <!-- recognition -->
            <div id="scorecard-results-5" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">

                                <div class="report-title">
                                    <h2 class="report-title">Appreciation & Recognition</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>Saying "thank you" goes a long way. Recognizing your team's hard work
                                                boosts morale and job satisfaction. It's not just about being nice; it's
                                                about creating a place where people love to work and give their best
                                                every day. Such positive reinforcement not only encourages staff to stay
                                                but also improves their commitment, leading to a stable, motivated team
                                                capable of delivering exceptional patient care.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-details">
                                    <?php if ($sub5 >= 5) { ?>
                                    <div class="circle green">
                                        <?php echo $sub5 ?> / 7
                                    </div>
                                    <?php } elseif($sub5 < 5 && $sub5 > 3 )  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub5 ?> / 7
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub5 ?> / 7
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- first row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Structured, Timely Feedback</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Intentional monthly appreciation and feedback provided to employees.</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['23'] == "Monthly/Planned" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['23'] ?>
                                        </div>
                                        <?php } elseif ($entry['23'] == "Quarterly/Planned" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['23'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['23'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['61'] != null) { ?>
                                        <p>
                                            <?php echo $entry['61'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['23'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Structured, Timely Feedback</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Formal peer recognition program in place</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['79'] == "Yes" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['79'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['79'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['80'] != null) { ?>
                                        <p>
                                            <?php echo $entry['80'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['79'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- recognition -->
            <!-- balance -->
            <div id="scorecard-results-6" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">

                                <div class="report-title">
                                    <h2 class="report-title">Work-Life Balance</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>Work-life balance is indispensable in the competitive environment of a
                                                veterinary hospital. Prioritizing this balance makes the hospital
                                                attractive to job seekers and is crucial for current staff's well-being.
                                                When a healthy work-life balance is maintained, it promotes job
                                                satisfaction, reduces stress, and minimizes burnout, resulting in a
                                                cohesive, dedicated team.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-details">
                                    <?php if ($sub6 >= 10) { ?>
                                    <div class="circle green">
                                        <?php echo $sub6 ?> / 14
                                    </div>
                                    <?php } elseif($sub6 < 10 && $sub6 >= 7)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub6 ?> / 14
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub6 ?> / 14
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- first row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Work predictability</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Set Schedule or at least 3 weeks in advance</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['25'] == "Yes" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['25'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['25'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['62'] != null) { ?>
                                        <p>
                                            <?php echo $entry['62'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['25'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Work predictability</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Leaves on time as indicated by the schedule</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['81'] == ">90% of the time" ) {?>
                                        <div class="green circle">More the 90% of the time</div>
                                        <?php } elseif ($entry['81'] == "50% to 90% of the time" ) {?>
                                        <div class="yellow circle">Between 50% and 90% of the time</div>
                                        <?php } else {?>
                                        <div class="red circle">Below 50% of the time</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['82'] != null) { ?>
                                        <p>
                                            <?php echo $entry['82'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['81'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Consecutive time off</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>At least 2 days off in a row</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['26'] == "Almost Always" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['26'] ?>
                                        </div>
                                        <?php } elseif ($entry['26'] == "Occasionally" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['26'] ?>
                                        </div>
                                        <?php } elseif ($entry['26'] == "Rarely" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['26'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['26'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['63'] != null) { ?>
                                        <p>
                                            <?php echo $entry['63'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['26'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Meal Breaks</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Employees receive and take at least a 30-minute meal break.</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['27'] == "Almost Always" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['27'] ?>
                                        </div>
                                        <?php } elseif ($entry['27'] == "Sometimes" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['27'] ?>
                                        </div>
                                        <?php } elseif ($entry['27'] == "Rarely" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['27'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['27'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['64'] != null) { ?>
                                        <p>
                                            <?php echo $entry['64'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['27'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- balance -->
            <!-- Leadership -->
            <div id="scorecard-results-7" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">

                                <div class="report-title">
                                    <h2 class="report-title">Leadership</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>Strong and consistent leadership is the backbone of staff retention.
                                                Effective management creates an environment where staff feel valued,
                                                supported, and empowered. This leadership quality enhances job
                                                satisfaction, fosters trust, and encourages long-term commitment to the
                                                hospital's mission, ultimately attracting and retaining top-tier talent.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-details">
                                    <?php if ($sub7 >= 12) { ?>
                                    <div class="circle green">
                                        <?php echo $sub7 ?> / 17
                                    </div>
                                    <?php } elseif($sub7 < 12 && $sub7 > 8 )  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub7 ?> / 17
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub7 ?> / 17
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- first row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>On-site leadership</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Manager or Supervisor On Site On All Working Days</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['30'] == "Yes" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['30'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['30'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['66'] != null) { ?>
                                        <p>
                                            <?php echo $entry['66'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['30'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Handbook</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Employee Handbook Been Updated Within the Last 3 Years</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['29'] == "Yes" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['29'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['29'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['65'] != null) { ?>
                                        <p>
                                            <?php echo $entry['65'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['29'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Job Descriptions</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>all positions have an updated job description with competencies listed</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['31'] == "Yes" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['31'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['31'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['67'] != null) { ?>
                                        <p>
                                            <?php echo $entry['67'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['31'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Job Descriptions</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Job descriptions are shared and signed by each employee upon hire</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['83'] == "Yes" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['83'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['83'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['84'] != null) { ?>
                                        <p>
                                            <?php echo $entry['84'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['83'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- Leadership -->
            <!-- Turnover  -->
            <div id="scorecard-results-8" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">

                                <div class="report-title">
                                    <h2 class="report-title">Turnover</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>Minimizing turnover is imperative for a veterinary hospital. Low turnover
                                                rates signal a stable work environment and translate into an
                                                experienced, skilled workforce. This stability enhances the quality of
                                                patient care and conserves resources that might otherwise be spent on
                                                frequent hiring and training.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-details">
                                    <?php if ($sub8 >= 12) { ?>
                                    <div class="circle green">
                                        <?php echo $sub8 ?> / 16
                                    </div>
                                    <?php } elseif($sub8 < 12 && $sub8 >= 8)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub8 ?> / 16
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub8 ?> / 16
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- first row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Turnover Rate</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Best < 10%, Good 10% - 30%</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['33'] == "< 10%" ) {?>
                                        <div class="green circle">Under 10% turnover rate</div>
                                        <?php } elseif ($entry['33'] == "10%-30%" ) {?>
                                        <div class="yellow circle">Between 10%-30% turnover rate</div>
                                        <?php } else {?>
                                        <div class="red circle">Over 30% turnover rate</div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['68'] != null) { ?>
                                        <p>
                                            <?php echo $entry['68'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['33'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Exit Interviews</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Exit interviews are conducted</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['38'] == "Always" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['38'] ?>
                                        </div>
                                        <?php } elseif ($entry['38'] == "Sometimes" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['38'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['38'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['69'] != null) { ?>
                                        <p>
                                            <?php echo $entry['69'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['38'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Exit Interviews</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Feedback from exit interviews is saved and processed</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['85'] == "Yes, saved and analyzed routinely" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['85'] ?>
                                        </div>
                                        <?php } elseif ($entry['85'] == "Saved, but not routinely analyzed" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['85'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['85'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['86'] != null) { ?>
                                        <p>
                                            <?php echo $entry['86'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['85'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Stay Interviews</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Routine check-ins performed with Employee to assess job satisfaction and
                                            collect feedback in a 1/1 setting </p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['46'] == "Always" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['46'] ?>
                                        </div>
                                        <?php } elseif ($entry['46'] == "Sometimes" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['46'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['46'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['70'] != null) { ?>
                                        <p>
                                            <?php echo $entry['70'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['46'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- Turnover  -->
            <!--  Employee survey  -->
            <div id="scorecard-results-9" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">

                                <div class="report-title">
                                    <h2 class="report-title">Employee Engagement Survey</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>Regular employee engagement surveys offer invaluable insights into staff
                                                morale, job satisfaction, and areas for improvement. These data-driven
                                                exercises guide actionable strategies for enhancing the work
                                                environment, thereby contributing to high-quality patient care and
                                                long-term organizational success.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-details">
                                    <?php if ($sub9 >= 8) { ?>
                                    <div class="circle green">
                                        <?php echo $sub9 ?> / 10
                                    </div>
                                    <?php } elseif($sub9 < 8 && $sub9 >= 5)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub9 ?> / 10
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub9 ?> / 10
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- first row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Employee Engagement Survey</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Performs an Anonymous Employee Engagement Survey on An Annual Basis</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['35'] == "Yearly" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['35'] ?>
                                        </div>
                                        <?php } elseif ($entry['35'] == "As Needed" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['35'] ?>
                                        </div>
                                        <?php } elseif ($entry['35'] == "Once" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['35'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['35'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['71'] != null) { ?>
                                        <p>
                                            <?php echo $entry['71'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['35'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Survey Action</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Action plans/smart goals are created and followed through with based on
                                            survey results</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['36'] == "Yes" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['36'] ?>
                                        </div>
                                        <?php } elseif ($entry['36'] == "Not Formally" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['36'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['36'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['72'] != null) { ?>
                                        <p>
                                            <?php echo $entry['72'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['36'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!--  Employee survey  -->
            <!-- Training  -->
            <div id="scorecard-results-10" class="results">
                <?php if ($entry['1'] != null) { ?>
                <div class="scorecard-section" class="marketing-section">
                    <div class="report">
                        <div class="row">
                            <div class="row-inner no-border">
                                <div class="report-title">
                                    <h2 class="report-title">Training</h2>
                                    <div class="info-icon-container">
                                        <span><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                        <div class="description-bubble">
                                            <p>Ongoing, structured training is vital for maintaining a competitive edge.
                                                Keeping your team updated and skilled means you can offer top-notch care
                                                to your patients, and it shows your staff that they're worth investing
                                                in! Regular training sessions keep the staff updated on industry
                                                advancements, contributing to better patient outcomes and higher job
                                                satisfaction. This culture of continuous learning equips the hospital to
                                                adapt to ever-changing demands, ensuring it remains a leader in
                                                delivering top-quality care.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="report-details">
                                    <?php if ($sub10 >= 18) { ?>
                                    <div class="circle green">
                                        <?php echo $sub10 ?> / 24
                                    </div>
                                    <?php } elseif($sub10 < 18 && $sub10 >= 12)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub10 ?> / 24
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub10 ?> / 24
                                    </div>
                                    <?php } ?>
                                    <div class="accordion-toggle">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus" style="display: none;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-bottom">
                            <!-- first row -->
                            <div class="row first-row">
                                <div class="row-inner no-border">
                                    <div class="col-one">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-three">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-four">
                                        <p>Why This Matters?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- first row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>New Hire Training</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Structured And Implemented on All New Hires</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['40'] == "Structured Training Plan" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['40'] ?>
                                        </div>
                                        <?php } elseif ($entry['40'] == "Unstructured Training" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['40'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['40'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['73'] != null) { ?>
                                        <p>
                                            <?php echo $entry['73'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['40'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>New Hire Training Completion</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Completion of Training Is Recognized</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['42'] == "Always" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['42'] ?>
                                        </div>
                                        <?php } elseif  ($entry['42'] == "Depends" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['42'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['42'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['75'] != null) { ?>
                                        <p>
                                            <?php echo $entry['75'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['42'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>New Hire Check-ins</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Check in done weekly with new hire and trainee</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['41'] == "Routine Check-ins" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['41'] ?>
                                        </div>
                                        <?php } elseif ($entry['41'] == "Occasional Check-ins" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['41'] ?>
                                        </div>
                                        <?php } elseif ($entry['41'] == "Check-in If Needed" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['41'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['41'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['74'] != null) { ?>
                                        <p>
                                            <?php echo $entry['74'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['41'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Development Plans</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Routine Development Plan Conversations with All Employees</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['43'] == "All Employees" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['43'] ?>
                                        </div>
                                        <?php } elseif ($entry['43'] == "For Some Employees" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['43'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['43'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['76'] != null) { ?>
                                        <p>
                                            <?php echo $entry['76'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['46'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Continuing Education</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>CE stipend provided for all medical/technical Employee (veterinarians and
                                            technicians/assistants)</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['44'] == "Everyone" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['44'] ?>
                                        </div>
                                        <?php } elseif ($entry['44'] == "Vets and Techs" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['44'] ?>
                                        </div>
                                        <?php } elseif ($entry['44'] == "Vets Only" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['44'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['44'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['77'] != null) { ?>
                                        <p>
                                            <?php echo $entry['77'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['44'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="row-inner">
                                    <div class="mobile-col">
                                        <p>Category</p>
                                    </div>
                                    <div class="col-one">
                                        <p>Ongoing Education</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Goal</p>
                                    </div>
                                    <div class="col-two">
                                        <p>Educational seminars offered routinely for all employees</p>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Hospital Status</p>
                                    </div>
                                    <div class="col-three">
                                        <?php if ($entry['45'] == "Frequently" ) {?>
                                        <div class="green circle">
                                            <?php echo $entry['45'] ?>
                                        </div>
                                        <?php } elseif ($entry['45'] == "Routinely" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['45'] ?>
                                        </div>
                                        <?php } elseif ($entry['45'] == "Ocassionally" ) {?>
                                        <div class="yellow circle">
                                            <?php echo $entry['45'] ?>
                                        </div>
                                        <?php } else {?>
                                        <div class="red circle">
                                            <?php echo $entry['45'] ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mobile-col">
                                        <p>Why This Matters?</p>
                                    </div>
                                    <div class="col-four">
                                        <?php if ($entry['78'] != null) { ?>
                                        <p>
                                            <?php echo $entry['78'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p>
                                            <?php echo $entry['45'] ?>
                                        </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- Training  -->

            <div class="overall-score scorecard-section">
                <div class="overall-score-head">
                    <?php if ($percentage >= 75 ) { ?>
                    <div class="total-score green">
                        <h2>
                            Overall Score:
                            <?php echo $percentage ?>%
                        </h2>
                    </div>
                    <?php } else if ($percentage < 75 && $percentage > 50) { ?>
                    <div class="total-score yellow">
                        <h2>
                            Overall Score:
                            <?php echo $percentage ?>%
                        </h2>
                    </div>
                    <?php } else { ?>
                    <div class="total-score red">
                        <h2>
                            Overall Score:
                            <?php echo $percentage ?>%
                        </h2>
                    </div>
                    <?php } ?>
                </div>
                <div class="overall-score-bottom">
                    <div class="bottom-column">
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Category</p>
                                </div>
                                <div class="col-four">
                                    <p>Your Score</p>
                                </div>
                            </div>
                        </div>
                        <div class="column-scores">
                            <div class="row-inner">
                                <h3>business listings</h3>
                                <div class="report-details">
                                    <?php if ($sub1 >= 6) { ?>
                                    <div class="circle green">
                                        <?php echo $sub1 ?> / 8
                                    </div>
                                    <?php } elseif($sub1 < 6 && $sub1 >= 4)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub1 ?> / 8
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub1 ?> / 8
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row-inner">
                                <h3>Brand Reputation</h3>
                                <div class="report-details">
                                    <?php if ($sub2 >= 9) { ?>
                                    <div class="circle green">
                                        <?php echo $sub2 ?> / 12
                                    </div>
                                    <?php } elseif (($sub2 < 9) && ($sub2 >= 6))  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub2 ?> / 12
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub2 ?> / 12
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row-inner">
                                <h3>Benefits</h3>
                                <div class="report-details">
                                    <?php if ($sub3 >= 11) { ?>
                                    <div class="circle green">
                                        <?php echo $sub3 ?> / 14
                                    </div>
                                    <?php } elseif (($sub3 < 11) && ($sub3 >= 7))  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub3 ?> / 14
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub3 ?> / 14
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row-inner">
                                <h3>Compensation</h3>
                                <div class="report-details">
                                    <?php if ($sub4 >= 7) { ?>
                                    <div class="circle green">
                                        <?php echo $sub4 ?> / 9
                                    </div>
                                    <?php } elseif($sub4 < 7 && $sub4 > 4)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub4 ?> / 9
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub4 ?> / 9
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row-inner">
                                <h3>Appreciation & Recognition</h3>
                                <div class="report-details">
                                    <?php if ($sub5 >= 5) { ?>
                                    <div class="circle green">
                                        <?php echo $sub5 ?> / 7
                                    </div>
                                    <?php } elseif($sub5 < 5 && $sub5 > 3 )  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub5 ?> / 7
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub5 ?> / 7
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="bottom-column">
                        <div class="row first-row">
                            <div class="row-inner no-border">
                                <div class="col-one">
                                    <p>Category</p>
                                </div>
                                <div class="col-four">
                                    <p>Your Score</p>
                                </div>
                            </div>
                        </div>
                        <div class="column-scores">
                            <div class="row-inner">
                                <h3>Work-Life Balance</h3>
                                <div class="report-details">
                                    <?php if ($sub6 >= 10) { ?>
                                    <div class="circle green">
                                        <?php echo $sub6 ?> / 14
                                    </div>
                                    <?php } elseif($sub6 < 10 && $sub6 >= 7)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub6 ?> / 14
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub6 ?> / 14
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row-inner">
                                <h3>Leadership</h3>
                                <div class="report-details">
                                    <?php if ($sub7 >= 12) { ?>
                                    <div class="circle green">
                                        <?php echo $sub7 ?> / 17
                                    </div>
                                    <?php } elseif($sub7 < 12 && $sub7 > 8 )  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub7 ?> / 17
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub7 ?> / 17
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row-inner">
                                <h3>Turnover</h3>
                                <div class="report-details">
                                    <?php if ($sub8 >= 12) { ?>
                                    <div class="circle green">
                                        <?php echo $sub8 ?> / 16
                                    </div>
                                    <?php } elseif($sub8 < 12 && $sub8 >= 8)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub8 ?> / 16
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub8 ?> / 16
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row-inner">
                                <h3>Employee Engagement Survey</h3>
                                <div class="report-details">
                                    <?php if ($sub9 >= 8) { ?>
                                    <div class="circle green">
                                        <?php echo $sub9 ?> / 10
                                    </div>
                                    <?php } elseif($sub9 < 8 && $sub9 >= 5)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub9 ?> / 10
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub9 ?> / 10
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row-inner">
                                <h3>Training</h3>
                                <div class="report-details">
                                    <?php if ($sub10 >= 18) { ?>
                                    <div class="circle green">
                                        <?php echo $sub10 ?> / 24
                                    </div>
                                    <?php } elseif($sub10 < 18 && $sub10 >= 12)  { ?>
                                    <div class="circle yellow">
                                        <?php echo $sub10 ?> / 24
                                    </div>
                                    <?php } else { ?>
                                    <div class="circle red">
                                        <?php echo $sub10 ?> / 24
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div id="btp">
                <a href="#recession-report" class="teal-btn" id="btp-btn">
                    <p>Back to top</p>
                    <!-- <i class="fas fa-caret-up"></i> -->
                </a>
            </div>
        </div>
    </div>
    <!-- RESULTS END -->

</div>
<?php
  return ob_get_clean();
}
add_shortcode('employer_scorecard_results','employer_scorecard_results');

wp_enqueue_script("jquery");