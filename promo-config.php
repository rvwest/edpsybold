<?php
return [
    [
        'keys' => ['jobs'],
        'html' => '<a href="/jobs/post/" class="edp-jobs-promo"><div class="promo-text"><div class="promo-title">Add your job</div><div class="promo-subtitle"><div>£400 for a 30-day listing</div><div> + mailout and social promos</div></div></div><i class="fal fa-plus-circle fa-2x"></i></a>',
    ],
    [
        'keys' => ['jobs/post'],
        'html' => '<a href="/jobs/choosing-edpsy-jobs/" class="edp-jobs-promo"><div class="promo-text"><div class="promo-title">Find out more</div><div class="promo-subtitle"><div>£400 for a 30-day listing</div><div> + mailout and social promos</div></div></div><i class="fal fa-question-circle fa-2x"></i></a>',
    ],
    [
        'keys' => ['thesis-directory'],
        'html' => '<a href="https://docs.google.com/forms/d/e/1FAIpQLSeeHm-OYkTotMzt99GuAbgP-j1rZBl3n54kPz4e-BWZDtz-Lg/viewform?usp=sf_link" class="edp-thesis-promo">Add your thesis<i class="fal fa-plus-circle fa-2x"></i></a>',
    ],
    [
        'keys' => ['interest-groups'],
        'html' => '<a href="https://edpsy.org.uk/interest-groups/add/" class="edp-thesis-promo">Add a group<i class="fal fa-plus-circle fa-2x"></i></a>',
    ],
    [
        'keys' => ['tribe_events'],
        'html' => '<a href="/events/community/add/" class="edp-events-promo">Add your event <i class="fal fa-plus-circle fa-2x"></i></a>',
    ],
    [
        'keys' => ['events/month/*'],
        'html' => '<a href="/events/community/add/" class="edp-blog-promo">Add your event <i class="fal fa-plus-circle fa-2x"></i></a>',
    ],
    [
        // Apply the same promo to /blog exactly, and to /tag and any /tag/*
        'keys' => ['blog', 'tag/*', 'author/*', 'category/*'],
        'html' => '<a href="/about/write-for-us/" class="edp-blog-promo" >Write for us <i class="fal fa-plus-circle fa-2x"></i></a>',
    ],
];