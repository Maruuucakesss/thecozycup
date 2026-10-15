@extends('layouts.app')
@section('title', 'Privacy Policy')

@section('content')
    <section class="wrap narrow legal">
        <h1>Privacy Policy</h1>
        <p class="muted">Last updated: October 15, 2026</p>

        <p>
            {{ config('shop.name') }} ("we", "us", "our") respects your privacy. This policy explains what personal
            information we collect through this website, why we collect it, how we use and protect it, and the rights
            you have under the Philippine Data Privacy Act of 2012 (Republic Act No. 10173) and its implementing rules.
            By creating an account or placing an order, you agree to the practices described here.
        </p>

        <h2>1. Who we are</h2>
        <p>
            {{ config('shop.name') }} ({{ config('shop.short') }}) is the personal information controller for this
            website. We are located at {{ config('shop.address') }}.
        </p>

        <h2>2. Information we collect</h2>
        <p><strong>Information you give us:</strong></p>
        <ul>
            <li><strong>Account details:</strong> your name, email address and password. Your password is stored only as a secure hash, so we cannot read it.</li>
            <li><strong>Order details:</strong> the items you order, your drink choices, quantities, totals, preferred time, and any note you add.</li>
            <li><strong>Contact and delivery details:</strong> your phone number, and your delivery address when you choose delivery.</li>
        </ul>
        <p><strong>Information collected automatically:</strong></p>
        <ul>
            <li><strong>Technical and security data:</strong> your IP address, recorded with certain actions such as placing an order, and basic browser information used to keep the site secure.</li>
            <li><strong>Cookies and similar technologies:</strong> see section 5.</li>
        </ul>
        <p>
            We do <strong>not</strong> collect payment card or e-wallet details, because you pay when you receive your
            order. We do not ask for government IDs or health records. If you write allergy or health information in an
            order note, we use it only to prepare your order safely.
        </p>

        <h2>3. How we use your information</h2>
        <ul>
            <li>To create and manage your account and log you in.</li>
            <li>To receive, prepare, and deliver or hand over your orders.</li>
            <li>To contact you about an order, and to show you its status on the "My orders" page.</li>
            <li>To keep business, accounting and tax records.</li>
            <li>To protect the website and our customers from fraud, abuse and unauthorized access, including keeping an activity log of administrator actions.</li>
            <li>To improve our menu and service, using order information in general form.</li>
            <li>To comply with the law and respond to lawful requests from authorities.</li>
        </ul>
        <p>
            We process your information because it is necessary to carry out your order, because you gave your consent
            when you signed up or checked out, because we have a legitimate interest in running and securing our
            business, or because the law requires it. We do not use your information for advertising or send
            promotional messages.
        </p>

        <h2>4. Who we share it with</h2>
        <p>We do not sell or rent your personal information. We share it only as needed:</p>
        <ul>
            <li><strong>Our staff,</strong> who can see order and account details to do their work.</li>
            <li><strong>Delivery riders,</strong> who receive your name, phone number, delivery address and order contents for delivery orders only.</li>
            <li><strong>Service providers,</strong> such as the companies that host this website and its database, who may process data for us and must keep it confidential.</li>
            <li><strong>Government agencies or courts,</strong> when we are required to by law.</li>
        </ul>

        <h2>5. Cookies and similar technologies</h2>
        <p>This website uses only the technologies it needs to work:</p>
        <ul>
            <li><strong>Session cookie:</strong> keeps you logged in and remembers your cart while you use the site.</li>
            <li><strong>Security cookie (XSRF-TOKEN):</strong> protects forms against forged requests.</li>
            <li><strong>Browser storage (sessionStorage):</strong> remembers that you accepted our Terms during your current visit. It is cleared when you close the tab.</li>
        </ul>
        <p>
            We do not use advertising, analytics or tracking cookies. You can block cookies in your browser settings,
            but logging in, the cart and checkout will not work without them.
        </p>

        <h2>6. Third-party services</h2>
        <p>
            Our pages load fonts from Google Fonts. When your browser requests them, Google receives your IP address
            and browser information under Google's own privacy practices. Links to other websites are governed by
            those websites' policies.
        </p>

        <h2>7. How long we keep your information</h2>
        <ul>
            <li>Account information is kept while your account is active.</li>
            <li>Order records are kept for as long as needed for accounting, tax and dispute purposes, then deleted or anonymized.</li>
            <li>Activity logs are kept for security and accountability for as long as we reasonably need them.</li>
        </ul>
        <p>You may ask us to delete your account. We will do so unless we must keep certain records by law.</p>

        <h2>8. How we protect your information</h2>
        <p>
            We use reasonable organizational, physical and technical safeguards, including hashed passwords,
            protection against forged requests, administrator-only access to customer data, and logging of
            administrator activity. No system is completely secure, but we work to protect your data. If a data
            breach that affects you occurs, we will notify you and the National Privacy Commission as required by law.
        </p>

        <h2>9. Your rights</h2>
        <p>Under the Data Privacy Act, you have the right to:</p>
        <ul>
            <li><strong>Be informed</strong> about how your personal information is processed.</li>
            <li><strong>Access</strong> the personal information we hold about you.</li>
            <li><strong>Correct</strong> information that is inaccurate or outdated.</li>
            <li><strong>Object</strong> to processing, or withdraw your consent, where the law allows.</li>
            <li><strong>Erase or block</strong> your information when it is no longer needed or was unlawfully obtained.</li>
            <li><strong>Data portability,</strong> where applicable.</li>
            <li><strong>Claim damages</strong> if your information was misused.</li>
            <li><strong>File a complaint</strong> with the National Privacy Commission at privacy.gov.ph.</li>
        </ul>
        <p>To use any of these rights, contact us using the details in section 12. We will respond within a reasonable time.</p>

        <h2>10. Children</h2>
        <p>
            This website is not meant for children under 13. Customers under 18 should order with the permission of a
            parent or guardian. If you believe a child has given us personal information without permission, contact
            us and we will delete it.
        </p>

        <h2>11. Changes to this policy</h2>
        <p>
            We may update this policy from time to time. The latest version is always on this page, with the date it
            was last updated. If a change is significant, we will make it clear on the website.
        </p>

        <h2>12. Contact us</h2>
        <p>
            {{ config('shop.name') }}<br>
            {{ config('shop.address') }}<br>
            @foreach(config('shop.hours') as $days => $time)
                {{ $days }}: {{ $time }}@if(!$loop->last)<br>@endif
            @endforeach
        </p>
        <p>You can visit the shop during opening hours to raise a privacy request or question.</p>
    </section>
@endsection
