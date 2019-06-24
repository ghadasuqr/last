@include ("frontend.layout.header")
@yield('content')
@include ("frontend.layout.footer")
<!--code for  add to wish list  -->
@include('frontend.layout.jscode')
<!--code for  add to wish list  -->
@yield('jscode')
<!-- code to rate -->
@yield('produtDetails')
@yield('rating')
<!-- cart javcascript -->
@yield('cartJS')
@yield('totalInvoiceJS') 
<!-- in frontend.orders.successO page -->

<!-- cart javcascript -->



</body>
</html>