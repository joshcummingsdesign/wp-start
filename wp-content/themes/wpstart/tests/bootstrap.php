<?php

declare(strict_types=1);

/**
 * Give Unit Tests Bootstrap
 *
 * @unreleased
 */
class SolidWebsiteUnitTestsBootstrap
{
    /**
     * The GiveWebsiteUnitTestsBootstrap instance.
     *
     * @unreleased
     */
    protected static ?self $instance = null;

    /**
     * Directory where wordpress-tests-lib is installed.
     *
     * @unreleased
     */
    public string $wpTestsDir;

    /**
     * The WordPress plugins directory.
     *
     * @unreleased
     */
    public string $wpPluginsDir;

    /**
     * The WordPress themes directory.
     *
     * @unreleased
     */
    public string $wpThemesDir;

    /**
     * The theme directory.
     *
     * @unreleased
     */
    public string $themeDir;

    /**
     * The theme directory name.
     *
     * @unreleased
     */
    public string $theme;

    /**
     * Instantiate the GiveWebsiteUnitTestsBootstrap class.
     *
     * @unreleased
     */
    public function __construct()
    {
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);

        // Ensure server variable is set for WP email functions.
        if ( ! isset($_SERVER['SERVER_NAME'])) {
            $_SERVER['SERVER_NAME'] = 'localhost';
        }

        $this->themeDir = dirname(__DIR__);
        $this->wpThemesDir = dirname($this->themeDir);
        $this->wpPluginsDir = dirname($this->wpThemesDir) . '/plugins';
        $this->wpTestsDir = getenv('WP_TESTS_DIR') ?: '/tmp/wp-test/wordpress-tests-lib';
        $this->theme = basename($this->themeDir);
        $manualBootstrap = isset($GLOBALS['manual_bootstrap']) ? (bool)$GLOBALS['manual_bootstrap'] : true;

        // Give access to tests_add_filter() function.
        require_once $this->wpTestsDir . '/includes/functions.php';

        // Load theme.
        tests_add_filter('muplugins_loaded', [$this, 'loadTheme']);

        // Load the WP testing environment
        if ($manualBootstrap) {
            require_once $this->wpTestsDir . '/includes/bootstrap.php';
        }
    }

    /**
     * Load the theme.
     *
     * @unreleased
     */
    public function loadTheme(): void
    {
        add_filter('theme_root', fn() => $this->wpThemesDir);
        register_theme_directory($this->wpThemesDir);
        add_filter('pre_option_template', fn() => $this->theme);
        add_filter('pre_option_stylesheet', fn() => $this->theme);
    }

    /**
     * Get the single class instance.
     *
     * @unreleased
     */
    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

SolidWebsiteUnitTestsBootstrap::instance();
