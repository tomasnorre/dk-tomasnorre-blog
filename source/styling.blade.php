---
title: Styling
description:
---
@extends('_layouts.main')

@section('body')
    <div class="content">

        <h1>Header 1</h1>
        <h2>Header 2</h2>
        <h3>Header 3</h3>
        <h4>Header 4</h4>
        <h5>Header 5</h5>
        <h6>Header 6</h6>

        <h2>Fonts</h2>
        <p class="font-sans">Font : The quick brown fox jumps over the lazy dog</p>
        <p class="font-mono">Font : The quick brown fox jumps over the lazy dog</p>

        <h2>Paragraph</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum quis mi tincidunt, egestas tortor sed,
            blandit est. Donec viverra, tellus a fringilla pulvinar, ipsum ligula rutrum risus, at dignissim leo eros eu
            urna.
            Nulla vestibulum dapibus porta. Pellentesque nisl lacus, semper ac sem at, consequat viverra justo.
            Aliquam rutrum ac neque et lacinia. <a href="#">Morbi dignissim fermentum lorem eu ultricies</a>.
            Aliquam accumsan tempus sem sed varius. In varius nibh felis. Quisque ultrices turpis et egestas
            consectetur.
            In lacinia, est tempor consectetur blandit, arcu est tristique tortor, in iaculis lectus libero sed lectus.
        </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum quis mi tincidunt, egestas tortor sed,
            blandit est. Donec viverra, tellus a fringilla pulvinar, ipsum ligula rutrum risus, at dignissim leo eros eu
            urna.
            Nulla vestibulum dapibus porta. Pellentesque nisl lacus, semper ac sem at, consequat viverra justo.
            Aliquam rutrum ac neque et lacinia. <a href="#">Morbi dignissim fermentum lorem eu ultricies</a>.
            Aliquam accumsan tempus sem sed varius. In varius nibh felis. Quisque ultrices turpis et egestas
            consectetur.
            In lacinia, est tempor consectetur blandit, arcu est tristique tortor, in iaculis lectus libero sed lectus.
        </p>

        <h2>Link</h2>
        <a href="#" class="link link-primary link-hover">Text Link - class: link link-primary link-hover</a><br/>
        <div id="menu-styling">
            <a href="#" class="link-primary no-underline ">Menu Link Inactive - class: link-primary
                no-underline</a><br/>
            <a href="#" class="link-primary no-underline active">Menu Link Active - class: link-primary no-underline
                active</a><br/>
        </div>

        <h2>Footer Link</h2>
        <a href="https://twitter.com/tomasnorre" class="link link-primary link-hover"
           aria-label="Link to my Twitter profile">
            <i class="fill-current text-2xl fa-brands fa-square-x-twitter"></i>
        </a>

        <h2>ol -> li</h2>
        <ol>
            <li>Item 1</li>
            <li>Item 2</li>
            <li>Item 3</li>
        </ol>

        <h2>ul -> li</h2>
        <ul>
            <li>Item 1</li>
            <li>Item 2</li>
            <li>Item 3</li>
        </ul>


    </div>
@endsection