/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
  // Hosted by text and url.
  wp.customize( 'showof_hosted_by_text', function( value ) {
    value.bind( function( to ) {
      $( '.site-info a.hosted-by' ).text('Proudly hosted by {0}'.format(to));
    } );
  } );
  wp.customize( 'showof_hosted_by_url', function( value ) {
    value.bind( function( to ) {
      $( '.site-info  a.hosted-by' ).prop('href',to );
    } );
  } );

} )( jQuery );

String.prototype.format = String.prototype.format = function() {
  var s = this,
    i = arguments.length;

  while (i--) {
    s = s.replace(new RegExp('\\{' + i + '\\}', 'gm'), arguments[i]);
  }
  return s;
};