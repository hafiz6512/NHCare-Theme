jQuery(document).ready(function($) {

    daimu();
    function daimu()
    {

        if($('.chk_fld').val()==1)
        {

            $('.img-upload-box').addClass('mod-up-box');
        }
        if($('.title_i').val()!=1)
        {

            $('.tt').attr('type','hidden');
        }
    }

//receive file from wordpress media
    $(document).on('click', '.fImgs', function() {

        current = $(this);
        if( null !== current) {
            var dfi_uploader = wp.media({

                title: WP_SPECIFIC.mediaSelector_title,
                button: {
                    text: WP_SPECIFIC.mediaSelector_buttonText
                },
                multiple: false,
            }).on('select', function() {
                var attachment = dfi_uploader.state().get('selection').first().toJSON(),
                    fullSize = attachment.url,
                    imgUrl = (typeof attachment.sizes.thumbnail === "undefined") ? fullSize : attachment.sizes.thumbnail.url,
                    imgUrlTrimmed, fullUrlTrimmed;
                imgUrlTrimmed = imgUrl.replace(WP_SPECIFIC.upload_url, "");
                fullUrlTrimmed = fullSize.replace(WP_SPECIFIC.upload_url, "");
                var fullSize = fullSize.split('/wp-content/');
                fullSize='/wp-content/'+fullSize[1];
                var featuredBox = current.parents('.frm_field');
                featuredBox.find('.img1').val(fullSize);

                featuredBox.find('.fImg').attr({
                    'src': fullSize,
                    'data-src': fullSize
                });
            }).open();
        }

        return false;

    });

//receive file from wordpress media
    $(document).on('click', '.fImgs2', function() {

        current = $(this);
        if( null !== current) {
            var dfi_uploader = wp.media({

                title: WP_SPECIFIC.mediaSelector_title,
                button: {
                    text: WP_SPECIFIC.mediaSelector_buttonText
                },
                multiple: false,
            }).on('select', function() {
                var attachment = dfi_uploader.state().get('selection').first().toJSON(),
                    fullSize = attachment.url,
                    imgUrl = fullSize,
                    imgUrlTrimmed, fullUrlTrimmed;
                imgUrlTrimmed = imgUrl.replace(WP_SPECIFIC.upload_url, "");
                fullUrlTrimmed = fullSize.replace(WP_SPECIFIC.upload_url, "");

                var fullSize = fullSize.split('/wp-content/');
                fullSize='/wp-content/'+fullSize[1];

                var featuredBox = current.parents('.frm_field');
                featuredBox.find('.img12').val(fullSize);

                featuredBox.find('.fImg2').attr({
                    'src': fullSize,
                    'data-src': fullSize
                });
            }).open();
        }

        return false;

    });
    function iiu() {
        var inputnum = parseInt($(".frm_i .field11").val()) + 1;
        var fld1='';
        if($('.frm_i .chk_fld').val()==1)
        {

            $('.frm_i .img-upload-box').addClass('mod-up-box');

            fld1='<p><textarea name="multiimage[]" class="area1" value="" placeholder="Text Content" /></textarea></p>';
        }

        $('.frm_i').append('<div class="frm_field img-upload-box" style="width: 47%;"><div class="close1 dashicons dashicons-minus" id="ItinerarySection"></div><div class="moree dashicons dashicons-plus content-with-image"></div><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="multiimage[]" value="" size="50" /><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Title" name="multiimage[]" /></p>'+fld1+'</div>');
        $('.frm_i .field11').val(inputnum);

        daimu();
    }

    function offeringContent() {
        var inputnum = parseInt($(".frm_i .field11").val()) + 1;
        var fld1='';
        if($('.frm_i .chk_fld').val()==1)
        {

            $('.frm_i .img-upload-box').addClass('mod-up-box');

            fld1='<p><textarea name="multiimage[]" class="area1" value="" placeholder="Text Content" /></textarea></p><p><select  name="multiimage[]"  class="tt"  style="width: 100%">' +
                '<option value="split-bg-color">background: black, h3: torquise, text: white</option>' +
                '<option value="split-bg-color-black">background: black, h3: torquise, text: white</option>' +
                '<option value="split-bg-color-red">background: red, h3: blue, text: white</option>' +
                '<option value="split-bg-color-black-green"> background: black, h3: tourquiose, text: white</option>' +
                '<option value="split-bg-color-green-black">background: tourquiose, h3: blue, text: black</option>' +
                '<option value="split-bg-color-blue-green">background: blue, h3: tourquiose, text: white</option>' +
                '<option value="split-bg-color-black-red">background: black, h3: red, text: white</option>' +
                '</select></p>';
        }

        $('.meta-box-sortables1').append('<div class="frm_field img-upload-box postbox" style="width: 47%;"><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="offeringContent"></div><div class="moree dashicons dashicons-plus content-with-image-offering"></div><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="multiimage[]" value="" size="50" /><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Title" name="multiimage[]" /></p>'+fld1+'</div></div>');
        $('.frm_i .field11').val(inputnum);
        daimu();
    }
    function mediaContent() {

        var inputnum = parseInt($(".frm_i .field12").val()) + 1;
        var inputnumcat = parseInt(jQuery(".field12-sub").val()) + 1;
        var fld1='';
        if($('.frm_i .chk_fld').val()==1)
        {

            $('.frm_i .img-upload-box').addClass('mod-up-box');

            fld1='<table style="width:100%" class="sub-'+inputnum+'"><tr><td><input type="button" class="button button-primary button-small" value="Add Sub Media Format" onclick="appendsub('+inputnum+')"></td></tr>'+
                '<tr class="subtr-'+inputnumcat+'"><td><input type="text" style="width:77%" placeholder="Sub Media Format Names" name="mediadata[]"><input type="button" class="button button-primary button-small delbut" value="Delete" onclick="deletesub('+inputnumcat+')"> </td></tr>'+
                '</table>';
        }

        $('.meta-box-sortables13').append('<div class="frm_field img-upload-box postbox" style="width: 31%;"><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="mediaContent"></div><div class="moree dashicons dashicons-plus content-with-image-media"></div><input type="hidden"   name="mediadata[]" value="ignyte_project_media_st"/><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="mediadata[]" value="" size="50" /><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Media Format Names" name="mediadata[]" /></p>'+fld1+'</div></div>');
        $('.frm_i .field12').val(inputnum);
        daimu();
    }

    function agentContent() {

        var inputnum = parseInt($(".frm_i .field12").val()) + 1;
        var inputnumcat = parseInt(jQuery(".field12-sub").val()) + 1;
        var fld1='';
        if($('.frm_i .chk_fld').val()==1)
        {

            $('.frm_i .img-upload-box').addClass('mod-up-box');

             var hhader='';
            var innerdata='';
            var myStringArray = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
            var arrayLength = myStringArray.length;
            for (var i = 0; i < arrayLength; i++) {
                //console.log(myStringArray[i]);
                hhader += "<td>"+myStringArray[i]+"</td>";
                innerdata +="<td><input type='hidden'  name='mediadata[]' value='hinit'><input type='hidden'  name='mediadata[]' value='"+myStringArray[i]+"'>" +
                    "<input type='text' class='timedate' placeholder='Open At (Ex- 7AM)' name='mediadata[]' value=''><br/>" +
                    "<input type='text' class='timedate' placeholder='Close At (Ex- 8PM) ' name='mediadata[]' value=''><br/>"+
                    "<input type='text' class='timedate' placeholder='Lunch Time' name='mediadata[]' value=''><br/>"+
                    "<select name='mediadata[]' class='timedate'>"+
                    "<option value='1' >Show This Day</option>"+
                    "<option value='2'>Hide This Day</option>"+
                    "</select></td>"
            }

            fld1='<p><textarea  rows="1" cols="40" style="width:80%" placeholder="Date Label" name="mediadata[]" class="area1" /></textarea></p><p><table class="main-table" border="1"> <tr class="heading">'+hhader+'</tr>'+
                '<tr> <input type="hidden"  name="mediadata[]" value="hinit33">'+innerdata+'</tr>'+
                '</table></p>';
        }

        $('.meta-box-sortables13').append('<div id="delk"  class="frm_field img-upload-box postbox" style="width: 100%;"><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="agentContent"></div><input type="hidden"   name="mediadata[]" value="ignyte_project_media_st"/>'+
            fld1+'</div></div>');
        $('.frm_i .field12').val(inputnum);
        daimu();
    }

    function agendaday() {

        var inputnum = parseInt($(".frm_i .field12").val()) + 1;
        // var inputnumcat = parseInt(jQuery(".field12-sub").val()) + 1;
        var fld1='';
        if($('.frm_i .chk_fld').val()==1)
        {

            $('.frm_i .img-upload-box').addClass('mod-up-box');

            fld1='<textarea  rows="1" cols="40" style="width:80%" placeholder="Date Label" name="mediadata[]" class="area1" /></textarea><textarea  rows="5" cols="40" style="width:80%" placeholder="Description" name="mediadata[]" class="area11" /></textarea>';
        }

        $('.meta-box-sortables13').append('<div id="delk"  class="frm_field img-upload-box postbox" style="width: 100%;"><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="agentContent"></div><input type="hidden"   name="mediadata[]" value="ignyte_project_media_date"/>'+
            '<p>'+fld1+'</p></div></div>');
        $('.frm_i .field12').val(inputnum);
        daimu();
    }

    function ignyteProgram() {
        var inputnum = parseInt($(".frm_programe .field11").val()) + 1;

        //$('.textarea-'+inputnum).mooEditable();


        $('.frm_programe').append('<div class="frm_field img-upload-box" style="width: 47%;"><div class="close1 dashicons dashicons-minus" id="ignyteProgram"></div><div class="moree dashicons dashicons-plus content-ignyteProgram"></div><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Title" name="ignyteProgram[]" /></p><p><textarea name="ignyteProgram[]" id="textarea-'+inputnum+'" class="area12" value="" placeholder="Text Content" /></textarea></p></div>');
        $('.frm_programe .field11').val(inputnum);
        //new MooEditable('textarea-1');
        new MooEditable('textarea-'+inputnum);
        daimu();
    }

    function sliderdiv() {
        var inputnum = parseInt($(".frm-v .field11").val()) + 1;

        if($('.chk_fld').val()==1)
        {

            $('.frm-v .img-upload-box').addClass('mod-up-box');

        }

        $('.meta-box-sortables2').append('<div class="frm_field img-upload-box postbox" style="width: 47%;"><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="sliderImageSection"></div><div class="moree dashicons dashicons-plus slider-pluse"></div><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="slider[]" value="" size="50" /></div></div>');
        $('.frm-v .field11').val(inputnum);

        daimu();
    }

    function banner() {
        var inputnum = parseInt($(".frm_banner .field11").val()) + 1;

        if($('.chk_fld').val()==1)
        {

            $('.frm_banner .img-upload-box').addClass('mod-up-box');

        }

        $('.frm_banner').append('<div class="frm_field img-upload-box" style="width: 95%;"><div class="close1 dashicons dashicons-minus" id="bannerImageSection"></div><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="ignyte_banner_image" value="" size="50" /></div>');
        $('.frm_banner .field11').val(inputnum);

        daimu();
    }

    function overviewImg() {
        var inputnum = parseInt($(".frm_overview .field11").val()) + 1;

        if($('.chk_fld').val()==1)
        {

            $('.frm_overview .img-upload-box').addClass('mod-up-box');

        }

        $('.frm_overview').append('<div class="frm_field img-upload-box" style="width: 50%;"><div class="close1 dashicons dashicons-minus" id="overviewImageSection"></div><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="overviewImg" value="" size="50" /></div>');
        $('.frm_overview .field11').val(inputnum);

        daimu();
    }


    function guaranteeIcon() {
        var inputnum = parseInt($(".frm_guarantee .field11").val()) + 1;

        $('.frm_guarantee').append('<div class="frm_field img-upload-box" ><div class="close1 dashicons dashicons-minus" id="guaranteeIcon"></div><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="guaranteeIcon" value="" size="50" /></div>');
        $('.frm_guarantee .field11').val(inputnum);

        daimu();
    }
    function caseStudyBigImage() {
        var inputnum = parseInt($(".frm_i .field11").val()) + 1;

        if($('.chk_fld').val()==1)
        {

            $('.frm_i .img-upload-box').addClass('mod-up-box');

        }
        $('.meta-box-sortables').append('<div class="frm_field img-upload-box casStudiesBox postbox" ><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="casestudySection"></div><div class="img-box fImgs"><img class="fImg" src="" /></div><input type="hidden" value="caseStudyBigImage" name="casestudiesdata[]"><input  class="img1" type="hidden" id="i'+inputnum+'" name="casestudiesdata[]" value="" size="50" /></div></div>');
        $('.frm_i .field11').val(inputnum);

        daimu();
    }

    function casestudy_testimonial() {
        var inputnum = parseInt($(".frm_i .field11").val()) + 1;

        if($('.frm_i .chk_fld').val()==1)
        {

            $('.frm_i .img-upload-box').addClass('mod-up-box');

        }
        $('.meta-box-sortables1').append('<div class="frm_field img-upload-box casStudiesBox postbox" ><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="casestudySection"></div><input type="hidden" value="casestudy_testimonial" name="casestudiesdata[]"><p>Select Testimonial <select name="casestudiesdata[]" id="casestudiesdata" onchange="gettestmoinalDetail(this.value,'+inputnum+')"  style="width:70%">'+optiontestmonial+'</select></p> <div id="testmoinalrep'+inputnum+'"></div></div></div>');
        $('.frm_i .field11').val(inputnum);

        daimu();
    }

    function casestudy_textcontent() {
        var inputnum = parseInt($(".frm_i .field11").val()) + 1;
        var fld1='';
        if($('.frm_i .chk_fld').val()==1)
        {
            $('.frm_i .img-upload-box').addClass('mod-up-box');

            fld1='<p><textarea name="casestudiesdata[]" class="area1" value="" placeholder="Text Content" /></textarea></p>';
        }
        $('.meta-box-sortables1').append('<div class="frm_field img-upload-box casStudiesBox postbox" ><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="casestudySection"></div><input type="hidden" value="casestudy_textcontent" name="casestudiesdata[]"><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Title" name="casestudiesdata[]" /></p>'+fld1+'</div></div>');
        $('.frm_i .field11').val(inputnum);

        daimu();
    }
    function caseStudyBigImagefortimeline() {
        var inputnum = parseInt($(".frm_i .field11").val()) + 1;

        if($('.frm_i .chk_fld').val()==1)
        {

            $('.frm_i .img-upload-box').addClass('mod-up-box');
            fld1234='<p><textarea name="casestudiesdata[]" class="area1" value="" placeholder="Text Content" /></textarea></p>';

        }
        $('.meta-box-sortables1').append('<div class="frm_field img-upload-box casStudiesBox postbox" ><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="casestudySection"></div><input type="hidden" value="caseStudyBigImage" name="casestudiesdata[]"><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Title" name="casestudiesdata[]" /></p><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="casestudiesdata[]" value="" size="50" />'+fld1234+'</div></div>');
        $('.frm_i .field11').val(inputnum);

        daimu();
    }
    function casstudiesvideo() {
        var inputnum = parseInt($(".frm_i .field11").val()) + 1;
        var fld1='';
        if($('.frm_i .chk_fld').val()==1)
        {
            $('.frm_i .img-upload-box').addClass('mod-up-box');

            fld1='<p><input type="text" value="" name="casestudiesdata[]" style="width: 80%" placeholder="Mp4 Video Url"><br/>'+
                '<input type="text" value="" name="casestudiesdata[]" style="width: 80%" placeholder="Ogv Video Url"><br/>'+
            '<input type="text" value="" name="casestudiesdata[]" style="width: 80%" placeholder="Webm Video Url">'+
            '</p><p><textarea name="casestudiesdata[]" class="area1" value="" placeholder="Text Content" /></textarea></p>';
        }
        $('.meta-box-sortables1').append('<div class="frm_field img-upload-box casStudiesBox postbox" ><div class="container hndle" style="padding-bottom:50px;"><div class="close1 dashicons dashicons-minus" id="casestudySection"></div><input type="hidden" value="casstudiesvideo" name="casestudiesdata[]"><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Title" name="casestudiesdata[]" /></p><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="casestudiesdata[]" value="" size="50" />'+fld1+'</div></div>');
        $('.frm_i .field11').val(inputnum);

        daimu();
    }
    function casestudy_2col_images() {
        var inputnum = parseInt($(".frm_i .field11").val()) + 1;
        var fld1='';
        if($('.frm_i .chk_fld').val()==1)
        {
            $('.frm_i .img-upload-box').addClass('mod-up-box');

            fld1='<p><textarea name="casestudiesdata[]" class="area1" value="" placeholder="Image Caption Text" /></textarea></p>';
        }
        $('.meta-box-sortables1').append('<div class="frm_field img-upload-box casStudiesBox postbox"><div class="container hndle"><div class="close1 dashicons dashicons-minus" id="casestudySection"></div><input type="hidden" value="casestudy_2col_images" name="casestudiesdata[]"><div style="width: 49%;float: left; margin-right: 1%"><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="i'+inputnum+'" name="casestudiesdata[]" value="" size="50" /><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Left Image Caption Title" name="casestudiesdata[]" /></p>'+fld1+'</div><div style="width: 49%;float: left; margin-left: 1%;"><div class="img-box fImgs2"><img class="fImg2" src="" /></div><input  class="img12" type="hidden" id="i'+inputnum+'" name="casestudiesdata[]" value="" size="50" /><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Reft Image Caption Title" name="casestudiesdata[]" /></p>'+fld1+'</div></div></div>');
        //$('.frm_i').append('<div class="frm_field img-upload-box" style="width: 47%;"><div class="close1 dashicons dashicons-minus" id="casestudySection"></div><div class="img-box fImgs"><img class="fImg" src="" /></div><input  class="img1" type="hidden" id="ii'+inputnum+'" name="casestudiesdata[]" value="" size="50" /><p><input class="tt txt'+inputnum+'" type="text" id="t'+inputnum+'" placeholder="Title" name="casestudiesdata[]" /></p>'+fld1+'</div>');
        $('.frm_i .field11').val(inputnum);

        daimu();
    }
    // add image title,description 
    $(document).on('click', '.content-with-image', function() {
        iiu();

    });
    $(document).on('click', '.content-with-image-offering', function() {
        offeringContent();

    });
    $(document).on('click', '.content-with-image-media', function() {
        mediaContent();

    });
    $(document).on('click', '.content-with-image-agenda', function() {
        agentContent();

    });

    $(document).on('click', '.content-casestudy', function() {
        var caseId = $(this).attr('id');
        if(caseId=="bigImage")
        {
            caseStudyBigImage();
        }
        if(caseId=="bigImage2")
        {
            caseStudyBigImagefortimeline();
        }
        if(caseId=="casestudy_textcontent")
        {
            casestudy_textcontent();
        }
        if(caseId=="casstudiesvideo")
        {
            casstudiesvideo();
        }
        if(caseId=="casestudy_2col_images")
        {
            casestudy_2col_images();
        }

        if(caseId=="casestudy_testimonial")
        {
            casestudy_testimonial();
        }

    });

    $(document).on('click', '.content-agends', function() {
        var caseId = $(this).attr('id');
        if(caseId=="agendaday")
        {
            agendaday();
        }
        if(caseId=="agendaimedescription")
        {
            agentContent();
        }


    });
    $(document).on('click', '.content-ignyteProgram', function() {
        ignyteProgram();

    });
    $(document).on('click', '.slider-pluse', function() {
        sliderdiv();

    });


    $(document).on('click', '.close1', function() {
        var id = $(this).attr('id');

        $(this).parents('.frm_field').remove();

        var inputnum = parseInt($(".field11").val())-1;
        $('.field11').val(inputnum);
        for(var i=0; i<inputnum;i++)
        {
            var u=i+1;
            $('.frm_field').eq(i).find('input[type=text],select').removeClass();
            $('.frm_field').eq(i).find('input[type=text],select').addClass('txt'+u);
        }

        if ($('.'+id).find( ".frm_field:first" ).length ) {


        }
        else
        {

            if(id=='bannerImageSection')
            {

                banner();
            }
            if(id=='guaranteeIcon')
            {
                guaranteeIcon();
            }
            if(id=='overviewImageSection')
            {
                overviewImg();
            }

            if(id=='ItinerarySection')
            {
                iiu();
            }

            if(id=='offeringContent')
            {
                offeringContent();
            }
            if(id=='mediaContent')
            {
                mediaContent();
            }

            if(id=='agentContent')
            {
                //agentContent();
                agendaday();
            }

            if(id=='sliderImageSection')
            {
                sliderdiv();
            }
            if(id=='ignyteProgram')
            {
                ignyteProgram();
            }

            if(id=='frm_callback2Icon')
            {
                frm_callback2Icon();
            }
            $('.modi').val(1);
        }


    });
});


jQuery(document).ready(function($)
{
    /*
    jQuery("body").hasClass("meta-box-sortables")
    {
        jQuery('.meta-box-sortables1 ,.meta-box-sortables2 , .meta-box-sortables13').sortable({
            opacity: 0.6,
            revert: true,
            cursor: 'move',
            handle: '.hndle'
        });
    }
    */

});


