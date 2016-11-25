<template>
<div class="home-page">
        <a href="#magpi"><img src="img/magpi-best-watermark-custom.png" class="magpi-watermark" alt="MagPi Top 50"></a>

        <div class="jumbotron">
            <div class="container text-sm-center">
                <h1 class="logo">MagicMirror<span class="two">²</span></h1>
                <p class="lead payoff">The open source modular smart mirror platform.</p>
                <p>
                    <a href="https://david-dm.org/MichMich/MagicMirror"><img src="https://david-dm.org/MichMich/MagicMirror.svg" alt="Dependency Status"></a>
                    <a href="https://david-dm.org/MichMich/MagicMirror#info=devDependencies"><img src="https://david-dm.org/MichMich/MagicMirror/dev-status.svg" alt="devDependency Status"></a>
                    <a href="https://bestpractices.coreinfrastructure.org/projects/347"><img src="https://bestpractices.coreinfrastructure.org/projects/347/badge"></a>
                    <a href="http://choosealicense.com/licenses/mit"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
                    <a href="https://travis-ci.org/MichMich/MagicMirror"><img src="https://travis-ci.org/MichMich/MagicMirror.svg" alt="Travis"></a>
                    <a href="https://snyk.io/test/github/MichMich/MagicMirror"><img src="https://snyk.io/test/github/MichMich/MagicMirror/badge.svg" alt="Known Vulnerabilities" data-canonical-src="https://snyk.io/test/github/MichMich/MagicMirror" style="max-width:100%;"></a>
                </p>
            </div>
        </div>

        <div class="container section links">
            <div class="row">
                <div class="col-md-4 text-sm-center animated fadeInUp">
                    <i class="fa fa-4x fa-github" aria-hidden="true"></i>
                    <h2>Open Source</h2>
                    <p>MagicMirror² is Open Source, free and maintained by a big group of enthusiasts. Got a nice idea? Send us a pull request and become a part of the big list of contributors.</p>
                    <p><br><a class="btn btn-primary" href="https://github.com/MichMich/MagicMirror" target="_blank">Go to the Repository &raquo;</a></p>
                </div>
                <div class="col-md-4 text-sm-center animated fadeInUp">
                    <i class="fa fa-4x fa-cubes" aria-hidden="true"></i>
                    <h2>Modular</h2>
                    <p>The core of MagicMirror² contains a strong API which allows 3rd party developers to build additional modules. Modules you can use. Modules you can develop.</p>
                    <p><br><a class="btn btn-primary" href="http://modules.magicmirror.builders" target="_blank">Check out the Modules &raquo;</a></p>
                </div>
                <div class="col-md-4 text-sm-center animated fadeInUp">
                    <i class="fa fa-4x fa-users" aria-hidden="true"></i>
                    <h2>Community driven</h2>
                    <p>On the forum you will find a big list of MagicMirror² enthusiasts. Share your ideas, ask your questions and get support. The perfect place for you to start.</p>
                    <p><br><a class="btn btn-primary" href="http://forum.magicmirror.builders" target="_blank">Visit the Forum &raquo;</a></p>
                </div>
            </div>
        </div>

        <div class="container section">
            <div class="row">
                <div class="col-md-8 offset-md-2 text-sm-center">
                    <h2>Watch the video:</h2>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/171152845" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <a name="magpi"></a>
        <div class="container section">
            <div class="row">
                <div class="col-xs-4 offset-xs-4 col-md-2 offset-md-5 text-sm-center">
                    <a href="http://magpi.cc/Issue-50" target="_blank"><img src="img/magpi-best-watermark-custom.png" alt="MagPi Top 50" class="img-fluid"></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-3 text-sm-center">
                    <h2>Voted number 1 in the MagPi Top 50!</h2>
                    <p class="lead">MagicMirror² is the winner in the official Raspberry Pi magazine’s 50th issue celebration feature voted by the Raspberry Pi community.</p>
                </div>
            </div>
        </div>

        <div class="container section">
            <div class="row">
                <div class="col-md-12 text-sm-center">
                    <h2>Easy to install!</h2>
                    <p class="lead">Want to install MagicMirror² on your freshly installed Raspbery Pi? Just run the following bash command:</p>
                    <pre>curl -sL https://raw.githubusercontent.com/MichMich/MagicMirror/master/installers/raspberry.sh | bash</pre>
                    <p>Prefer a manual installation? Check out the <a  href="https://github.com/MichMich/MagicMirror#manual-installation" target="_blank">installation guide</a>! </p>
                </div>
            </div>
        </div>

        <div class="container section">
            <div class="row">
                <div class="col-md-12 text-sm-center">
                    <h3>Interested in developing your own modules?</h3>
                    <p>
                        MagicMirror² has an extensively documentated API. It allows you to built your own module backed by a powerful backend.<br>
                        Check out the <a href="https://github.com/MichMich/MagicMirror/blob/master/modules/README.md" target="_blank">API documentation</a> for more information and start developing today.
                    </p>

                    <h3>Interested in similar projects?</h3>
                    <p>
                        Check out the <a href="http://michaelteeuw.nl" target="_blank">Blog of Michael Teeuw</a>, creator of the MagicMirror² project. Or follow Michael on <a href="http://twitter.com/michmich" target="_blank">Twitter</a> and <a href="http://instagram.com/michaelteeuw" target="_blank">Instagram</a>.
                    </p>
                </div>
            </div>
        </div>

        <div class="container section footer-image">
            <div class="row">
                <div class="col-md-12 text-sm-center">
                    <img src="img/explode.jpg" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        
    }
</script>