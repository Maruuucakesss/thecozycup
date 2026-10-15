<aside class="authside tex dots">
    <span class="eyebrow">{{ config('shop.name') }}</span>
    <h2>{{ $title }}</h2>
    <p>{{ $text }}</p>
    @if($perks ?? true)
        <ul>
        <li>Order ahead and skip the wait</li>
        <li>Customize every cup your way</li>
        <li>Track your orders in one place</li>
    </ul>
    @endif
</aside>
