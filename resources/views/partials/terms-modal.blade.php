{{--
    Shown on every new visit to the site (new tab, or the site reopened).
    NOT shown again on refresh or when moving between pages in the same tab.
    Accepting is remembered with sessionStorage, which the browser clears when the tab is closed.
--}}
<div class="modal" id="termsModal" role="dialog" aria-modal="true" aria-labelledby="termsTitle">
    <form class="modal-box" id="termsForm">
        <div class="modal-head">
            <img class="mlogo" src="{{ asset('assets/logo-mark.png') }}" alt="">
            <h2 id="termsTitle">Before you continue</h2>
            <p class="muted">Please read and accept our Terms &amp; Conditions to browse {{ config('shop.name') }}. Scroll to read everything.</p>
        </div>

        <div class="modal-body legal">
            @include('partials.terms-content', ['popup' => true])
        </div>

        <div class="modal-foot">
            <label class="opt">
                <span>
                    <input type="checkbox" id="termsAgree" required>
                    <span>I have read and agree to the Terms &amp; Conditions and Privacy Policy.</span>
                </span>
            </label>

            <p class="err" id="termsNote" hidden>You need to accept the Terms &amp; Conditions to use this site.</p>

            <div class="acts">
                <button type="button" class="btn ghost" id="termsDecline">Decline</button>
                <button class="btn" id="termsAccept">I agree</button>
            </div>
        </div>
    </form>
</div>

<noscript><style>.modal { display: none; }</style></noscript>

<script>
    (function () {
        var form = document.getElementById('termsForm');
        var box = document.getElementById('termsAgree');
        var accept = document.getElementById('termsAccept');
        var note = document.getElementById('termsNote');

        accept.disabled = true;
        box.addEventListener('change', function () {
            accept.disabled = !box.checked;
            if (box.checked) { note.hidden = true; }
        });

        document.getElementById('termsDecline').addEventListener('click', function () {
            note.hidden = false;
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            try { sessionStorage.setItem('tcc_terms', '1'); } catch (err) {}
            document.documentElement.classList.add('terms-ok');
        });

        box.focus();
    })();
</script>
