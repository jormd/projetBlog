var gulp = require ('gulp'), // rewrite and versioning
    livereload = require('gulp-livereload'), //livereload
    sass = require('gulp-sass'), // Conversion des SCSS en CSS
    minifyCss = require('gulp-minify-css'), // Minification des CSS
    rename = require('gulp-rename'), // Minification des CSS
    autoprefixer = require('gulp-autoprefixer'); // Minification des CSS

var src = ['./src/AppBundle/Resources/public/saas/*.scss'];

// SCSS TASK
gulp.task('css', function()
{
    return gulp.src(src)    // Prend en entrée les fichiers *.scss
        .pipe(sass())                      // Compile les fichiers
        .pipe(minifyCss({keepBreaks: false}))   // Minifie le CSS qui a été généré
        .pipe(rename({suffix: '.min'}))
        .pipe(autoprefixer({
            browsers: ['last 3 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('./web/css/'))  // Sauvegarde le tout dans /src/assets/css
        .pipe(livereload());

});


// WATCH TASK
gulp.task('watch', function()
{
    livereload.listen();
    gulp.watch(src, ['css']);
});

gulp.task('default', ['css', 'watch']);