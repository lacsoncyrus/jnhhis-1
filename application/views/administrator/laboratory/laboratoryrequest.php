<section id="main-content">
  <section class="wrapper">
    <div class="row">
      <div class="col-sm-3">
          <section class="panel">
              <header class="panel-heading" style="background-color: #000;"></header>
              <table class="table">
                <tr>
                  <td colspan="2" align="center">Search Request :<br><br>
<script type="text/javascript"> $(window).load(function(){ $("#search1").keyup(function () { var value = this.value.toLowerCase().trim(); $("#tables tr").each(function (index) { if (!index) return; $(this).find("td").each(function () { var id = $(this).text().toLowerCase().trim(); var not_found = (id.indexOf(value) == -1); $(this).closest('tr').toggle(!not_found); return not_found; }); }); }); }); </script>

                  <input class="form-control" type="text" size="18%" id="search1" placeholder="Type to Search">
                  </td>
                </tr>
              </table>
          </section>
      </div>
      <div class="col-sm-9">
          <section class="panel">
              <header class="panel-heading" style="background-color: #000;"></header>
              <header class="panel-heading">
                  <center><h4>ROOM LIST<h4></center>
              </header>
              <table class="table table-hovered" style="text-align: center;">
                <tr id="tblheader">
                    <td>Request #</td>
                    <td>Date Added</td>
                    <td>Check-In #</td>
                    <td>Patient</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>
              </table>
          </section>
      </div>
    </div>
  </section>
</section>
