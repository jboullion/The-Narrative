jQuery(function($){
	// const youtube_search_url = 'https://www.googleapis.com/youtube/v3/search?key=AIzaSyB2Tczkqj-yEx0_bAOZrDo6Exec7VMi970';
	// //var nextPageToken = '';
	// var channelVideoList = [];

	// get_channel_list('UCpMcsdZf2KkAnfmxiq2MfMQ', 50, '', true);
	
	// /**
	//  * Get a list of all the videos for this channel. Max of 50 per query
	//  * 
	//  * @param {string} channel_id This is the ID of the Channel in the YouTube system
	//  * @param {int} maxResults The number of videos to retun
	//  * @param {string} pageToken  This is a string returned by YT which will get the paged results
	//  * @param {bool} all Should we return all of this channels videos or just a single page
	//  */
	// function get_channel_list(channel_id, maxResults, pageToken, all){
	// 	if(! maxResults){
	// 		maxResults = 20;
	// 	}

	// 	if(pageToken){
	// 		pageToken = '&pageToken='+pageToken;
	// 	}

	// 	$.get(youtube_search_url+'&channelId='+channel_id+'&part=snippet,id&order=date&maxResults='+maxResults+pageToken, function( data ) {
			
	// 		channelVideoList.push.apply(data.items);
			
	// 		// If there are more pages after this, GET THEM!
	// 		if(all && data.nextPageToken){
	// 			//get_channel_list('UCpMcsdZf2KkAnfmxiq2MfMQ', maxResults, data.nextPageToken, all);
	// 		}

	// 	}, 'json');
	// }

	
});