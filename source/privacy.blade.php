---
title: Privacy
description:
---
@extends('_layouts.main')

@section('body')

    <h1>Privacy Policy for {{ $page->siteAuthor }}</h1>

    <p>At {{ $page->siteName }}, accessible from {{ $page->baseUrl }}, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by {{ $page->siteName }} and how we use it.</p>

    <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us. Our Privacy Policy was generated with the help of <a href="https://www.gdprprivacypolicy.net/">GDPR Privacy Policy Generator from GDPRPrivacyPolicy.net</a></p>

    <h2>General Data Protection Regulation (GDPR)</h2>
    <p>We are a Data Controller of your information.</p>

    <p>{{ $page->siteAuthor }} legal basis for collecting and using the personal information described in this Privacy Policy depends on the Personal Information we collect and the specific context in which we collect the information:</p>
    <ul>
        <li>{{ $page->siteAuthor }} needs to perform a contract with you</li>
        <li>You have given {{ $page->siteAuthor }} permission to do so</li>
        <li>Processing your personal information is in {{ $page->siteAuthor }} legitimate interests</li>
        <li>{{ $page->siteAuthor }} needs to comply with the law</li>
    </ul>

    <p>{{ $page->siteAuthor }} will retain your personal information only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use your information to the extent necessary to comply with our legal obligations, resolve disputes, and enforce our policies.</p>

    <p>If you are a resident of the European Economic Area (EEA), you have certain data protection rights. If you wish to be informed what Personal Information we hold about you and if you want it to be removed from our systems, please contact us.</p>

    <p>In certain circumstances, you have the following data protection rights:</p>
    <ul>
        <li>The right to access, update or to delete the information we have on you.</li>
        <li>The right of rectification.</li>
        <li>The right to object.</li>
        <li>The right of restriction.</li>
        <li>The right to data portability</li>
        <li>The right to withdraw consent</li>
    </ul>

    <h2>Log Files</h2>

    <p>{{ $page->siteName }} follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information.</p>




    <h2>Privacy Policies</h2>

    <P>You may consult this list to find the Privacy Policy for each of the advertising partners of {{ $page->siteName }}.</p>

    <p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on {{ $page->siteName }}, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>

    <p>Note that {{ $page->siteName }} has no access to or control over these cookies that are used by third-party advertisers.</p>

    <h2>Third Party Privacy Policies</h2>

    <p>{{ $page->siteName }}'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options. </p>

    <p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites.</p>

    <h2>Children's Information</h2>

    <p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p>

    <p>{{ $page->siteName }} does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p>

    <h2>Online Privacy Policy Only</h2>

    <p>Our Privacy Policy created at <a href="https://www.gdprprivacypolicy.net/">GDPRPrivacyPolicy.net</a> applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in {{ $page->siteName }}. This policy is not applicable to any information collected offline or via channels other than this website.</p>

    <h2>Consent</h2>

    <p>By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p>

@endsection