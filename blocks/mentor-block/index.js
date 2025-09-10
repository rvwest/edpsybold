( function( blocks, element, blockEditor, components ) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var RichText = blockEditor.RichText;
    var PlainText = blockEditor.PlainText;
    var MediaUpload = blockEditor.MediaUpload;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var Button = components.Button;
    var URLInput = blockEditor.URLInput;

    registerBlockType( 'edpsy/mentor', {
        edit: function( props ) {
            var attrs = props.attributes;

            function onSelectImage( media ) {
                props.setAttributes( { imageID: media.id, imageURL: media.url } );
            }

            return [
                el( InspectorControls, {},
                    el( PanelBody, { title: 'Mentor link', initialOpen: true },
                        el( URLInput, {
                            value: attrs.link,
                            onChange: function( value ) { props.setAttributes( { link: value } ); }
                        } )
                    )
                ),
                el( 'div', { className: props.className },
                    el( MediaUpload, {
                        onSelect: onSelectImage,
                        allowedTypes: [ 'image' ],
                        value: attrs.imageID,
                        render: function( obj ) {
                            return attrs.imageURL ?
                                el( 'img', { src: attrs.imageURL, className: 'mentor-image', onClick: obj.open } ) :
                                el( Button, { onClick: obj.open, className: 'button button-large' }, 'Select Image' );
                        }
                    } ),
                    el( PlainText, {
                        tagName: 'div',
                        className: 'mentor-name',
                        value: attrs.name,
                        onChange: function( value ) { props.setAttributes( { name: value } ); },
                        placeholder: 'Name'
                    } ),
                    el( PlainText, {
                        tagName: 'div',
                        className: 'mentor-role',
                        value: attrs.role,
                        onChange: function( value ) { props.setAttributes( { role: value } ); },
                        placeholder: 'Role'
                    } ),
                    el( RichText, {
                        tagName: 'div',
                        className: 'mentor-description',
                        value: attrs.description,
                        onChange: function( value ) { props.setAttributes( { description: value } ); },
                        placeholder: 'Description'
                    } )
                )
            ];
        },
        save: function() {
            return null;
        }
    } );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components );
