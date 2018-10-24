<?php

show_admin_bar(false);

require_once 'inc/helpers.php';
require_once 'inc/config.php';

require_once 'inc/theme-setup.php';
require_once 'inc/widgets-init.php';
require_once 'inc/wp-enqueue-scripts.php';
require_once 'inc/cleaning.php';
require_once 'inc/shortcodes.php';
require_once 'inc/comment-form.php';

require_once 'inc/rss-turbo.php';

require_once 'inc/authenticate.php';
require_once 'inc/admin.php';
require_once 'inc/login.php';

require_once 'inc/customizer.php';

require_once 'inc/ajax/ContactForm.php';
require_once 'inc/ajax/LoadMorePosts.php';

require_once 'inc/class/SnazzyMaps.php';

require_once 'inc/class/GoogleMaps.php';
require_once 'inc/class/GoogleMapsCustomizer.php';

require_once 'inc/class/GoogleTagManager.php';

require_once 'inc/class/GoogleReCaptcha.php';
require_once 'inc/class/GoogleReCaptchaCustomizer.php';

require_once 'inc/class/ChangeSiteURL.php';

require_once 'inc/class/SRI.php';

require_once 'inc/class/JPWalkerComment.php';
