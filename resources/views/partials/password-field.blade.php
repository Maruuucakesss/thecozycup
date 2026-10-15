{{--
    Password input with a show/hide (eye) button.
    Optional 'rules' => true adds the strength rules (8+ characters, uppercase, number, special symbol)
    with a live checklist. Use it where a NEW password is chosen.

    Usage: @include('partials.password-field', ['name' => 'password', 'label' => 'Password',
                                                 'autocomplete' => 'new-password', 'rules' => true])
--}}
@php
    $id = $id ?? $name;
    $rules = $rules ?? false;
@endphp

<div class="field">
    <label for="{{ $id }}">{{ $label }}</label>
    <div class="pw">
        <input type="password" id="{{ $id }}" name="{{ $name }}" required
               autocomplete="{{ $autocomplete ?? 'current-password' }}"
               @if($rules)
                   minlength="8"
                   pattern="(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}"
                   title="{{ \App\Support\StrongPassword::MESSAGE }}"
                   data-checks="{{ $id }}-rules"
               @elseif(isset($minlength))
                   minlength="{{ $minlength }}"
               @endif>
        <button type="button" class="pw-toggle" aria-label="Show password" aria-pressed="false">
            <svg class="eye" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>
            </svg>
            <svg class="eye-off" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.94 17.94A10.4 10.4 0 0 1 12 19c-6.4 0-10-7-10-7a18.5 18.5 0 0 1 4.06-5.06M9.9 4.24A9.8 9.8 0 0 1 12 4c6.4 0 10 7 10 7a18.6 18.6 0 0 1-2.16 3.19M1 1l22 22"/>
                <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
            </svg>
        </button>
    </div>

    @if($rules)
        <p class="pwhint">Your password must have at least 8 characters, an uppercase letter, a number and a special symbol (like ! @ # $ - _).</p>
        <ul class="pwrules" id="{{ $id }}-rules" aria-live="polite">
            <li data-rule="len">8+ characters</li>
            <li data-rule="upper">Uppercase letter</li>
            <li data-rule="num">Number</li>
            <li data-rule="sym">Special symbol</li>
        </ul>
    @endif
</div>

@once
    <script>
        // Eye button: one listener handles every password field on the page.
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.pw-toggle');
            if (!btn) { return; }
            var input = btn.parentNode.querySelector('input');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.classList.toggle('on', show);
            btn.setAttribute('aria-pressed', show);
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        });

        // Live checklist for new passwords.
        document.addEventListener('input', function (e) {
            var input = e.target;
            if (!input.dataset || !input.dataset.checks) { return; }
            var list = document.getElementById(input.dataset.checks);
            var v = input.value;
            var ok = {
                len: v.length >= 8,
                upper: /[A-Z]/.test(v),
                num: /[0-9]/.test(v),
                sym: /[^A-Za-z0-9]/.test(v)
            };
            list.querySelectorAll('li').forEach(function (li) {
                li.classList.toggle('ok', ok[li.dataset.rule]);
            });
        });
    </script>
@endonce
