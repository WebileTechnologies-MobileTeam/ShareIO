
// console.log('hmm');
if(window.jQuery){
  // console.log('yes/');
  jQuery(document).ready(function($){
    // console.log('.sticktobottom-close-con -> ', $('.sticktobottom-close-con'))
    $(document).on('click.dzsiconhide', '.sticktobottom-close-con,.sticktobottom-close-con .svg-icon', function () {
      var _t = $(this);

      $('.dzsap-sticktobottom .audioplayer').get(0).api_pause_media();


      // console.log('_t sticktobottom-close-con -7', _t);

      var _con = null;

      if (_t.parent().hasClass("dzsap-sticktobottom")) {
        _con = _t.parent();
      }
      if (_t.parent().parent().hasClass("dzsap-sticktobottom")) {
        _con = _t.parent().parent();
      }
      if (_t.parent().parent().parent().hasClass("dzsap-sticktobottom")) {
        _con = _t.parent().parent().parent();
      }

      console.log('_con - ', _con, _con.hasClass('audioplayer-loaded'));

      if (_con.hasClass('audioplayer-loaded')) {

        _con.removeClass('audioplayer-loaded');
        _con.addClass('audioplayer-was-loaded');


      } else {

        _con.addClass('audioplayer-loaded');
        _con.addClass('audioplayer-was-loaded');
      }

      return false;
    })



    $(document).on('click.dzsiconshow', '.dzsap-sticktobottom .icon-show', function () {
      var _t = $(this);


      // _t.parent().parent().addClass('audioplayer-loaded');
      // _t.parent().parent().removeClass('audioplayer-was-loaded');
      //
      // _t.parent().parent().parent().addClass('audioplayer-loaded');
      // _t.parent().parent().parent().removeClass('audioplayer-was-loaded');

      return false;
    })
  })
}
