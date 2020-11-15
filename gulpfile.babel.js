'use strict';

import {task, src, dest, watch, series, parallel} from 'gulp';
import sass from 'gulp-sass';
import babel from 'gulp-babel';
import uglify from 'gulp-uglify';
import svgmin from 'gulp-svgmin';
import rename from 'gulp-rename';
import plumber from 'gulp-plumber';
import svgstore from 'gulp-svgstore';
import cleancss from 'gulp-clean-css';
import browser_sync from 'browser-sync';
//import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'gulp-autoprefixer';

const browserSync = browser_sync.create();

task('svg', () => {
    return src('assets/img/svg/*.svg')
        .pipe(plumber())
        .pipe(svgmin({
            plugins: [
                {removeViewBox: false},
                {removeUselessDefs: true},
            ],
            js2svg: {pretty: false}
        }))
        .pipe(svgstore({inlineSvg: true}))
        .pipe(rename({basename: 'sprite', extname: '.svg'}))
        .pipe(dest('assets/img/'));
});

task('sass', () => {
    return src('assets/sass/**/*.scss')
        .pipe(plumber())
        //.pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: ['assets/sass'],
            indentType: 'space',
            indentWidth: 2,
            linefeed: 'crlf',
            outputStyle: 'expanded', // nested, expanded, compact, compressed
            precision: 5,
            sourceComments: false
        }).on('error', sass.logError))
        .pipe(autoprefixer({cascade: false, grid: 'autoplace'}))
        //.pipe(sourcemaps.write('/'))
        .pipe(dest('./'))
        .pipe(browserSync.stream());
});

task('css', () => {
    return src('style.css')
        .pipe(plumber())
        //.pipe(sourcemaps.init())
        .pipe(cleancss({compatibility: 'ie7', debug: true}))
        .pipe(rename({suffix: '.min'}))
        //.pipe(sourcemaps.write('/'))
        .pipe(dest('./'));
});

task('babel', () => {
    return src('assets/js/es6/**/*.js')
        .pipe(plumber())
        .pipe(babel())
        .pipe(uglify({
            mangle: false,
            compress: false,
            output: {
                beautify: true,
            },
        }))
        .pipe(dest('assets/js'));
});

task('js', () => {
    return src('assets/js/common.js')
        .pipe(plumber())
        //.pipe(sourcemaps.init())
        .pipe(uglify({
            mangle: false,
            compress: false,
        }))
        .pipe(rename({suffix: '.min'}))
        //.pipe(sourcemaps.write('/'))
        .pipe(dest('assets/js'));
});

task('min', parallel('css', 'js'));

task('watch', () => {
    watch('assets/img/svg/*.svg', series('svg'));
    watch('assets/sass/**/*.scss', series('sass'));
    watch('assets/js/es6/**/*.js', series('babel'));
});

task('default', () => {
    browserSync.init({
        baseDir: './',
        ghostMode: false,
        //proxy: 'http://yourlocal.dev',
    });
    watch('assets/img/svg/*.svg', series('svg'));
    watch('assets/sass/**/*.scss', series('sass'));
    watch('assets/js/es6/**/*.js', series('babel'));
    //watch('style.css', series('css'));
    //watch('assets/js/common.js', series('js'));
    watch('style.css').on('change', browserSync.reload);
    watch('assets/js/common.js').on('change', browserSync.reload);
    watch('**/*.php').on('change', browserSync.reload);
});
