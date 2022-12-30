<footer class="footer d-none d-sm-block">
    <div class="footer-inner bgc-white-tp1">
        <div class="pt-3 border-none border-t-3 brc-grey-l2">
            <span class="text-secondary-m1 font-bolder text-120">iMacPlus</span>
            <span class="text-grey">Application &copy; <?=date('Y')?> version 1.0</span>

            <span class="mx-3 action-buttons">
<!--                      <a href="#" class="text-blue-m2 text-150"><i class="fab fa-twitter-square"></i></a>-->
                      <a href="#" class="text-blue-d2 text-150"><i class="fab fa-facebook"></i></a>
                      <a href="#" class="text-orange-d1 text-150"><i class="fa fa-rss-square"></i></a>
                   </span>
        </div>
    </div><!-- .footer-inner -->

    <!-- `scroll to top` button inside footer (for example when in boxed layout) -->
    <div class="footer-tools">
        <a href="#" class="btn-scroll-up btn btn-dark mb-2 mr-2">
            <i class="fa fa-angle-double-up mx-2px text-95"></i>
        </a>
    </div>
</footer>



<!-- footer toolbox for mobile view -->
<footer class="d-sm-none footer footer-sm footer-fixed">
    <div class="footer-inner">
        <div class="btn-group d-flex h-100 mx-2 border-x-1 border-t-2 brc-primary-m3 bgc-white-tp1 radius-t-1 shadow">
            <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0" data-toggle="modal" data-target="#id-ace-settings-modal">
                <i class="fas fa-sliders-h text-blue-m1 text-120"></i>
            </button>

            <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0">
                <i class="fa fa-plus-circle text-green-m1 text-120"></i>
            </button>

            <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0" data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle navbar search">
                <i class="fa fa-search text-orange text-120"></i>
            </button>

            <button class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0 mr-0">
                  <span class="pos-rel">
                      <i class="fa fa-bell text-purple-m1 text-120"></i>
                      <span class="badge badge-dot bgc-red position-tr mt-n1 mr-n2px"></span>
                  </span>
            </button>
        </div>
    </div>
</footer>
</div>


</div>
</div>

<!-- include common vendor scripts used in demo pages -->
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/popper.js/dist/umd/popper.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>

<script src="./node_modules/tiny-date-picker/dist/date-range-picker.js"></script>
<script src="./node_modules/moment/moment.js"></script>
<script src="./node_modules/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>

<!-- include vendor scripts used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-scripts.hbs" -->
<!--<script src="node_modules/chart.js/dist/Chart.js"></script>-->


<script src="node_modules/sortablejs/dist/sortable.umd.js"></script>



<!-- include ace.js -->
<script src="dist/js/ace.js"></script>



<!-- demo.js is only for Ace's demo and you shouldn't use it -->
<script src="app/browser/demo.js"></script>

<script src="node_modules/datatables/media/js/jquery.dataTables.js"></script>
<script src="node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="node_modules/datatables.net-colreorder/js/dataTables.colReorder.js"></script>
<script src="node_modules/datatables.net-select/js/dataTables.select.js"></script>


<!--alert-->
<script src="node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
<script src="node_modules/interactjs/dist/interact.js"></script>

<!-- include vendor scripts used in "Wizard & Validation" page. see "/views//pages/partials/form-wizard/@vendor-scripts.hbs" -->
<script src="node_modules/smartwizard/dist/js/jquery.smartWizard.js"></script>


<script src="node_modules/jquery-validation/dist/jquery.validate.js"></script>

<script src="node_modules/inputmask/dist/jquery.inputmask.js"></script>


<!-- Cookie Consent by https://www.cookiewow.com -->
<script type="text/javascript" src="https://cookiecdn.com/cwc.js"></script>
<script id="cookieWow" type="text/javascript" src="https://cookiecdn.com/configs/Jym9Mew5dSqHUru8AVmSbTHX" data-cwcid="Jym9Mew5dSqHUru8AVmSbTHX"></script>

<!-- "Dashboard" page script to enable its demo functionality -->
<!--<script src="views/pages/dashboard/@page-script.js"></script>-->
<script src="views/pages/page-profile/@page-script.js"></script>
<script src="views/pages/form-wizard/@page-script.js"></script>
<script src="views/pages/form-basic/@page-script.js"></script>
<script src="views/pages/form-upload/@page-script.js"></script>
</body>

</html>