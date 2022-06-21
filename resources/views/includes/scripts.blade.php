<!-- JS -->
<script src="{{ asset('js/app.js') }}"></script>

<script type="text/javascript">
  AOS.init();
</script>
@stack('scripts')

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-175306336-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-175306336-1');
</script>
