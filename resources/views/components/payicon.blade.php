<style>
    .payicon {
        width : 23px;
        float : right;
        vertical-align:bottom;
        v-align : bottom;
    }
</style>
<div class="d-inline-block w-50" style="">
    @switch ($payment)
        @case(1)
        <!-- Cash -->
        <!-- img class="payicon" src="{{ asset('images/icons8-cash-64x.png') }}"/ -->
        @break

        @case(2)
        <!-- Check -->
        <img class="payicon" data-toggle="tooltip" title="Check Payment" alt="Check" src="{{ asset('images/icons8-check-book-64.png') }}"/>
        @break

        @case(3)
        <!-- Online -->
        <img class="payicon" data-toggle="tooltip" title="Online Deposit" alt="Online" src="{{ asset('images/icons8-online-money-transfer-64.png') }}"/>
        @break

        @case(4)
        <!-- Mobile Deposit -->
        <img class="payicon" data-toggle="tooltip" title="Mobile Deposit" alt="Deposit" src="{{ asset('images/icons8-mobile-payment-64.png') }}"/>
        @break
    @endswitch
</div>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>