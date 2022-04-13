<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo wp_get_document_title() ?></title>

    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php wp_head() ?>

    <script>
        /*global $ */
        $ = jQuery;
        $(document).ready(function() {

            "use strict";

            $('.menu > ul > li:has( > ul)').addClass('menu-dropdown-icon');

            $('.menu > ul > li > ul:not(:has(ul))').addClass('normal-sub');

            $(".menu > ul").before("<a href=\"#\" class=\"menu-mobile\">Navigation</a>");

            /*
            $(".menu > ul > li").hover(function(e) {
              if ($(window).width() > 943) {
                $(this).children("ul").stop(true, false).fadeToggle(150);
                e.preventDefault();
              }
            });
            */
            $(".menu > ul > li").mouseenter(function(e) {
                if ($(window).width() > 943) {
                    $(this).children("ul").stop(true, false).fadeIn(150);
                    e.preventDefault();
                }
            });

            $(".menu > ul > li").mouseleave(function(e) {
                if ($(window).width() > 943) {
                    $(this).children("ul").stop(true, false).fadeOut(150);
                    e.preventDefault();
                }
            });


            $(".menu > ul > li").click(function() {
                if ($(window).width() <= 943) {
                    $(this).children("ul").fadeToggle(150);
                }
            });

            $(".menu-mobile").click(function(e) {
                $(".menu > ul").toggleClass('show-on-mobile');
                e.preventDefault();
            });

        });
    </script>

</head>

<body <?php body_class() ?>>

    <header class="header">
        <!-------- полоса системных ссылок -------->
        <div class="system_menu">
            <div class="container">
                <div class="system_menu__items">
                    <div class="system_menu__item syslink__wrapper">
                        <a href="#" class="system_menu-link">О компании</a>
                        <a href="#" class="system_menu-link">Доставка и оплата</a>
                        <a href="#" class="system_menu-link">Контакты</a>
                        <a href="#" class="system_menu-link">Новости</a>
                    </div>
                    <div class="system_menu__item authlink__wrapper">
                        <div class="menu__link_search">
                            <div itemscope itemtype="https://schema.org/WebSite">
                                <meta itemprop="url" content="{Ваш домен}" />
                                <form itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction">
                                    <meta itemprop="target" content="{Ваш домен}/search?q={search_term_string}" />
                                    <input itemprop="query-input" type="text" name="search_term_string" required />
                                    <input type="submit" value="Поиск" />
                                </form>
                            </div>
                        </div>
                        <div class="system__menu_link">
                            <a href="#" class="system_menu-link">Вход</a> |
                            <a href="#" class="system_menu-link">Регистрация</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--------/ полоса системных ссылок -------->
        <div class="container">
            <div class="header__content">
                <div class="header__item logo" itemscope itemtype="http://schema.org/Organization">
                    <a itemprop="url" href="/">
                        <img itemprop="logo" src="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>logo.png" />
                    </a>
                </div>
                <!-- /.logo -->
                <div class="header__item company__info">
                    <div class="adress">
                        <picture>
                            <source srcset="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>location.webp" type="image/webp" />
                            <img class="adress_image" src="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>location.png" alt="Адресс" />
                        </picture>
                        <span>г. Москва, Ильменский проезд, 13с17</span>
                    </div>
                    <div class="time_work">
                        <picture>
                            <source srcset="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>time-work.webp" type="image/webp" />
                            <img src="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>time-work.webp" alt="Время работы" />
                        </picture>
                        Пн-Вс: 10:00-20:00
                    </div>
                </div>
                <!-- /.company__info -->
                <div class="header__item company__call">
                    <div class="call__link">
                        <a href="tel:+7(988)400-70-97">+7(988)400-70-97</a>
                    </div>
                    <div class="call__buttom">
                        <a href="#" class="click__buttom">Обратный звонок</a>
                    </div>
                </div>
                <!-- /.company__call -->
                <div class="header__item comerce__element">
                    <div class="element__rating">
                        <a href="">
                            <picture>
                                <source srcset="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>reating.webp" type="image/webp" />
                                <img src="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>reating.webp" alt="Сравнение">
                            </picture>
                            <br>Сравнение
                        </a>
                    </div>
                    <div class="element__love">
                        <a href="">
                            <picture>
                                <source srcset="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>favorit.webp" type="image/webp" />
                                <img src="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>favorit.png" alt="Сравнение">
                            </picture><br>
                            Избранное
                        </a>
                    </div>
                    <div class="element__busket">
                        <a href="">
                            <picture>
                                <source srcset="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>busket.webp" type="image/webp" />
                                <img src="<?= esc_url(get_template_directory_uri() . '/assets/img/') ?>busket.png" alt="Сравнение">
                            </picture><br>
                            Корзина
                        </a>
                    </div>
                </div>
                <!-- /.shop__module -->
            </div>
            <!-- /.header__content -->


            <div class="header__navmenu">
                <?php
                wp_nav_menu(array(
                    'menu'              => 'head_menu', // ID, имя или ярлык меню
                    'menu_class'        => 'head_menu', // класс элемента <ul>
                    'menu_id'           => '', // id элемента <ul>
                    'container'         => 'nav', // тег контейнера или false, если контейнер не нужен
                    'container_class'   => 'menu', // класс контейнера
                    'container_id'      => '', // id контейнера
                    'fallback_cb'       => 'wp_page_menu', // колбэк функция, если меню не существует
                    'before'            => '', // текст (или HTML) перед <a
                    'after'             => '', // текст после </a>
                    'link_before'       => '', // текст перед текстом ссылки
                    'link_after'        => '', // текст после текста ссылки
                    'echo'              => true, // вывести или вернуть
                    'depth'             => 0, // количество уровней вложенности
                    'walker'            => '', // объект Walker
                    'theme_location'    => 'head_menu', // область меню
                    'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'item_spacing'      => 'preserve',
                ));
                ?>
            </div>
            <? 
            /**
             * Hook: woocommerce_before_main_content.
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             * @hooked WC_Structured_Data::generate_website_data() - 30
             */
            do_action( 'woocommerce_before_main_content' );
            ?>
        </div>
        <!-- /.nav menu -->
    </header>
    <!--------/ header -------->




    <style>
        .menu-mobile {
            display: none;
            padding: 20px;
        }

        .menu-mobile:after {
            content: "+";
            font-size: 2.5rem;
            padding: 0;
            float: right;
            position: relative;
            top: 50%;
            transform: translateY(-25%);
        }

        .menu-dropdown-icon:before {
            content: "+";
            display: none;
            cursor: pointer;
            float: right;
            padding: 1.5em 2em;
            background: #fff;
            color: #333;
        }

        .menu>ul {
            position: relative;
            box-sizing: border-box;
        }

        .menu>ul:before,
        .menu>ul:after {
            content: "";
            display: table;
        }

        .menu>ul:after {
            clear: both;
        }

        .menu>ul>li {
            float: left;
            background: #e9e9e9;
            padding: 0;
            margin: 0;
        }

        .menu>ul>li a {
            padding: .8em 3em;
            display: block;
        }

        .menu>ul>li:hover {
            background: #f0f0f0;
        }

        .menu>ul>li>ul {
            display: none;
            width: 100%;
            background: #f0f0f0;
            padding: 20px;
            position: absolute;
            z-index: 99;
            left: 0;
            margin: 0;
            list-style: none;
            box-sizing: border-box;
        }

        .menu>ul>li>ul:before,
        .menu>ul>li>ul:after {
            content: "";
            display: table;
        }

        .menu>ul>li>ul:after {
            clear: both;
        }

        .menu>ul>li>ul>li {
            margin: 0;
            padding-bottom: 0;
            list-style: none;
            width: 25%;
            background: none;
            float: left;
        }

        .menu>ul>li>ul>li a {
            padding: 0.2em 0;
            width: 95%;
            display: block;
            border-bottom: 1px solid #ccc;
        }

        .menu>ul>li>ul>li>ul {
            display: block;
            padding: 0;
            margin: 10px 0 0;
            list-style: none;
            box-sizing: border-box;
        }

        .menu>ul>li>ul>li>ul:before,
        .menu>ul>li>ul>li>ul:after {
            content: "";
            display: table;
        }

        .menu>ul>li>ul>li>ul:after {
            clear: both;
        }

        .menu>ul>li>ul>li>ul>li {
            float: left;
            width: 100%;
            padding: 10px 0;
            margin: 0;
            font-size: 0.8em;
        }

        .menu>ul>li>ul>li>ul>li a {
            border: 0;
        }

        .menu>ul>li>ul.normal-sub {
            width: 300px;
            left: auto;
            padding: 10px 20px;
        }

        .menu>ul>li>ul.normal-sub>li {
            width: 100%;
        }

        .menu>ul>li>ul.normal-sub>li a {
            border: 0;
            padding: 1em 0;
        }

        /* ––––––––––––––––––––––––––––––––––––––––––––––––––
Mobile style's
–––––––––––––––––––––––––––––––––––––––––––––––––– */
        @media only screen and (max-width: 959px) {
            .menu-container {
                width: 100%;
            }

            .menu-mobile {
                display: block;
            }

            .menu-dropdown-icon:before {
                display: block;
            }

            .menu>ul {
                display: none;
            }

            .menu>ul>li {
                width: 100%;
                float: none;
                display: block;
            }

            .menu>ul>li a {
                padding: 1.5em;
                width: 100%;
                display: block;
            }

            .menu>ul>li>ul {
                position: relative;
            }

            .menu>ul>li>ul.normal-sub {
                width: 100%;
            }

            .menu>ul>li>ul>li {
                float: none;
                width: 100%;
                margin-top: 20px;
            }

            .menu>ul>li>ul>li:first-child {
                margin: 0;
            }

            .menu>ul>li>ul>li>ul {
                position: relative;
            }

            .menu>ul>li>ul>li>ul>li {
                float: none;
            }

            .menu .show-on-mobile {
                display: block;
            }
        }
    </style>


    <!--<nav>
          <ul class="navmenu__links" itemscope itemtype="http://www.schema.org/SiteNavigationElement">
            <li itemprop="name">
              <a itemprop="url" href="{ссылка}">Акция</a>
            </li>
            <li itemprop="name">
              <a itemprop="url" href="{ссылка}">Телефоны</a>
            </li>
            <li itemprop="name">
              <a itemprop="url" href="{ссылка}">Ноутбуки</a>
            </li>
            <li itemprop="name">
              <a itemprop="url" href="{ссылка}">Планшеты</a>
            </li>
            <li itemprop="name">
              <a itemprop="url" href="{ссылка}">Холодильники</a>
            </li>
            <li itemprop="name">
              <a itemprop="url" href="{ссылка}">Кофеварки</a>
            </li>
          </ul>
        </nav> -->