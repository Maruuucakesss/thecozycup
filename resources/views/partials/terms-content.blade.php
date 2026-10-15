{{-- Full Terms & Conditions. Used on /terms and inside the first-visit pop-up. --}}
@php $t = ($popup ?? false) ? ' target="_blank" rel="noopener"' : ''; @endphp
<p class="muted">Last updated: October 15, 2026</p>

        <p>
            Welcome to {{ config('shop.name') }}. These Terms &amp; Conditions ("Terms") apply to your use of this
            website and to every order you place through it. Please read them carefully. By using the website,
            creating an account or placing an order, you agree to these Terms and to our
            <a href="{{ route('privacy') }}"{!! $t !!}>Privacy Policy</a>. If you do not agree, please do not use the website.
        </p>

        <h2>1. About us</h2>
        <p>
            This website is operated by {{ config('shop.name') }} ({{ config('shop.short') }}), located at
            {{ config('shop.address') }}. In these Terms, "we", "us" and "our" mean {{ config('shop.name') }}, and
            "you" means the person using the website.
        </p>

        <h2>2. Accounts</h2>
        <ul>
            <li>You need an account to place orders. Browsing the menu does not require one.</li>
            <li>You must give accurate and current information, including a working phone number.</li>
            <li>You are responsible for keeping your password private and for everything done through your account. Tell us right away if you think someone else is using it.</li>
            <li>Customers under 18 should place orders with the permission of a parent or guardian.</li>
            <li>We may suspend or close an account that is used for fake or abusive orders, or that breaks these Terms.</li>
        </ul>

        <h2>3. Using the website</h2>
        <p>You agree not to:</p>
        <ul>
            <li>place false, prank or repeated fake orders;</li>
            <li>use the website for anything unlawful or harmful;</li>
            <li>try to gain unauthorized access, interfere with the website, or copy or scrape it in bulk; or</li>
            <li>use another person's details without their permission.</li>
        </ul>

        <h2>4. Menu, photos and availability</h2>
        <p>
            We try to keep the menu accurate, but photos are for illustration and the actual product may look slightly
            different. Items, sizes and add-ons may be unavailable at times. We may change or remove menu items at any
            time, and if an item in your cart becomes unavailable it will be removed from your cart.
        </p>

        <h2>5. Prices and fees</h2>
        <ul>
            <li>All prices are in Philippine pesos (₱).</li>
            <li>Drink prices depend on the serving you choose (Cold 16 oz or Hot 12 oz) and any add-ons you select. The total is shown in your cart and at checkout.</li>
            <li>Pickup orders have no delivery fee. Delivery orders include a delivery fee, which we set and show at checkout before you place your order.</li>
            <li>Prices and the delivery fee may change at any time. A change only applies to orders placed after it. If we find a pricing error, we may correct it and contact you before preparing your order.</li>
        </ul>

        <h2>6. Placing an order</h2>
        <ul>
            <li>Placing an order is a request to buy. It is not confirmed until we accept it. We may accept or decline any order, for example when an item is unavailable or we are closed or very busy.</li>
            <li>You can follow your order on the "My orders" page, where its status shows as pending, accepted, on the way or ready for pickup, completed or cancelled.</li>
            <li>The "preferred time" you choose is a request, not a guarantee. Preparation and delivery times are estimates.</li>
            <li>You are responsible for checking your name, phone number, address and order details before you submit them.</li>
        </ul>

        <h2>7. Pickup</h2>
        <p>
            For pickup orders, collect your order at our store at {{ config('shop.address') }} once it is marked ready.
            Please collect it promptly. Orders that are not collected within a reasonable time after they are ready,
            and at most 1 hour, may be discarded without refund.
        </p>

        <h2>8. Delivery</h2>
        <ul>
            <li>For delivery orders you must enter a complete and correct delivery address, and keep your phone reachable.</li>
            <li>We may decline or cancel a delivery to an address that is outside the area we serve or that we cannot find or reach safely.</li>
            <li>Delivery times are estimates and can be affected by traffic, weather and order volume.</li>
            <li>If no one is available to receive the order after reasonable attempts to reach you, we may treat the order as cancelled, and the price of the prepared items may still be due.</li>
            <li>Drinks and food can spill or change temperature in transit. Please check your order when you receive it.</li>
        </ul>

        <h2>9. Payment</h2>
        <p>
            We do not take payments on this website. You pay in cash when you receive your order: at the counter for
            pickup, or to our rider for delivery. Please prepare the exact amount when possible.
        </p>

        <h2>10. Cancellations and problems with your order</h2>
        <ul>
            <li>You may ask to cancel an order before we start preparing it by contacting the shop. We cannot cancel or refund drinks and food that are already prepared, unless the order is wrong or has a quality problem.</li>
            <li>We may cancel an order, for example because an item is unavailable, a delivery is not possible, or we cannot reach you.</li>
            <li>If your order is wrong, missing items or has a quality problem, tell us as soon as you receive it. We will remake it, replace the item or refund you, at our reasonable discretion.</li>
        </ul>

        <h2>11. Allergens and food safety</h2>
        <p>
            Our drinks and pastries may contain or come into contact with milk, soy, nuts, gluten, eggs and other
            allergens, and our coffee and matcha drinks contain caffeine. Our products are prepared in a shared
            kitchen, so we cannot guarantee that any item is free of a particular allergen. If you have an allergy or a
            health condition, tell our staff before ordering and, for online orders, write it in the order note.
            You order at your own risk if you do not.
        </p>

        <h2>12. Intellectual property</h2>
        <p>
            The {{ config('shop.name') }} name, logo, photos, text and design of this website belong to us or are used
            with permission. You may not copy, reproduce or use them for commercial purposes without our written
            permission.
        </p>

        <h2>13. Privacy</h2>
        <p>
            We collect and use your personal information as described in our
            <a href="{{ route('privacy') }}"{!! $t !!}>Privacy Policy</a>.
        </p>

        <h2>14. Website availability and liability</h2>
        <ul>
            <li>We try to keep the website available and accurate, but we do not promise that it will always be error-free or uninterrupted.</li>
            <li>To the fullest extent allowed by law, we are not liable for indirect or consequential losses arising from your use of the website, or for delays or failures caused by events outside our reasonable control.</li>
            <li>Nothing in these Terms limits any right you have under Philippine consumer protection laws, or any liability that cannot be limited by law.</li>
        </ul>

        <h2>15. Changes to these Terms</h2>
        <p>
            We may update these Terms from time to time. The latest version is always on this page, with the date it
            was last updated. If you keep using the website after a change, you accept the updated Terms.
        </p>

        <h2>16. Governing law</h2>
        <p>
            These Terms are governed by the laws of the Republic of the Philippines. Any dispute that cannot be settled
            between us will be brought before the proper courts of Tarlac, Philippines.
        </p>

        <h2>17. Contact us</h2>
        <p>
            {{ config('shop.name') }}<br>
            {{ config('shop.address') }}<br>
            @foreach(config('shop.hours') as $days => $time)
                {{ $days }}: {{ $time }}@if(!$loop->last)<br>@endif
            @endforeach
        </p>
        <p>You can visit the shop during opening hours with any question about these Terms or your order.</p>
