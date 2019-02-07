<?php

show_admin_bar(false);

require_once 'inc/config.php';
require_once 'inc/helpers.php';

require_once 'inc/theme-setup.php';
require_once 'inc/widgets-init.php';
require_once 'inc/wp-enqueue-scripts.php';
require_once 'inc/cleaning.php';
require_once 'inc/shortcodes.php';
require_once 'inc/comment-form.php';

//require_once 'inc/rss-turbo.php';

require_once 'inc/authenticate.php';
require_once 'inc/admin.php';
require_once 'inc/login.php';

require_once 'inc/customizer.php';

require_once 'classes/ajax/ContactForm.php';
require_once 'classes/ajax/LoadMorePosts.php';

require_once 'classes/SnazzyMaps.php';

require_once 'classes/Social.php';
require_once 'classes/Messengers.php';
require_once 'classes/ScrollTop.php';
require_once 'classes/GoogleMaps.php';
require_once 'classes/GoogleMapsCustomizer.php';

require_once 'classes/GoogleTagManager.php';

require_once 'classes/GoogleReCaptcha.php';
require_once 'classes/GoogleReCaptchaCustomizer.php';

//require_once 'classes/ChangeSiteURL.php';

//require_once 'classes/SRI.php';

require_once 'classes/JPWalkerComment.php';

require_once 'classes/OpenGraph.php';
require_once 'classes/AutoPosting.php';
