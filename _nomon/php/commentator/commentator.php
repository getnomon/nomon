<?php  /* Commentator 0.7.5 (c) 2009-2011 R Holt ( http://ratherodd.com/commentator/ )  */
//require_once("php/lib/tamberfb.php");
$akismet_file = false;                          // path to the Akismet class. Set this to false if you don't want to use it.
//$wpAPIkey = 'xxxxxxxxxx';                                     // your WordPress API key. Needed for Akismet to work. Get it at akismet.com
//$commentator_from = 'Website Name <noreply@example.com>';     // name and email address you want the email to be from
//$email_owner = 'me@example.com';                              // your email address. Used to identify you as author of your own comments
$preview = false;                                              // allows users to preview comments before submitting
$send_email_on_new_comment = false;                            // If true, when a new comment is pasted, $email_owner is sent an email with the comment
$commentator_password = 'password';                           // password for managing comments
$gravatars = false;                                            // Use of gravatars. Set to false to disable, true to use default. Supports other gravatar defaults (see http://en.gravatar.com/site/implement/images/#default-image)
$comments_per_page = 10;                                      // Number of comments to display. This will enable pagination. Set to false to disable pagination
$newest_first = true;                                         // Order comments to display newest comments first. Set to false to display in chronological order. This setting applies with or without pagination
$mark_as_spam_and_delete = true;                              // When you click "mark as spam", if set to true, this will automatically delete the comment as well. Marking spam helps the Akismet service.
$allowed_html = '<a><i><b><em><u><s><strong><code><pre><p>';  // Allow simple HTML in comments. Set to false to disable HTML altogether
$htmlfixer_file = 'htmlfixer.class.php';                      // HtmlFixer class file. Set to false if not allowing any HTML or to disable

// This file (mysql.php) must provide a function called "mysql_connection" which returns the connection reference itself. It should use PHP's mysqli_ functions (not the older mysql_ ones).
// Alternatively, provide your own mysql link somehow (on line 37) or uncomment the function at the bottom of this script and use that. Remove the comment (//) for whichever you intend to use.

//include_once(dirname(__FILE__) . '/mysql.php');

/*** Don't edit anything below this line unless you know what you're doing! ***/

error_reporting(E_ALL ^ E_NOTICE);

class Commentator {
  public function __construct($page, $title = false, $artist) {
  	$this->artist = $artist;
  	$this->tamberFacebook = $GLOBALS['facebook'];
  	
    $this->page = $page;
    $this->domain = 'http://' . $_SERVER['HTTP_HOST'];
    
    // Don't use this
    $this->akismet_file = dirname(__FILE__) . '/' . $GLOBALS['akismet_file'];
    $this->wpAPIkey = $GLOBALS['wpAPIkey'];
    
    $this->email_owner = $GLOBALS['email_owner'];
    $this->from = $GLOBALS['commentator_from'];
    $this->password = $GLOBALS['commentator_password'];
    
    // gravatars set to false - we dont use it. 
    $this->gravatars = $GLOBALS['gravatars'];
    
    
    
    $this->allowed_html = $GLOBALS['allowed_html'];
    $this->depth = '    ';
    $this->here = preg_replace(array('/&?show=[a-z]+/', '/\?&/'), array('','?'), $this->domain . $_SERVER['REQUEST_URI']);
    $this->newest_first = $_GET['first'] ? $_GET['first'] === 'newest' : (bool)$GLOBALS['newest_first'];
    $this->title = $title ? $title : $this->here;
    if (function_exists('mysql_connection')) {
      $this->link = mysql_connection();
      
      // add varchar 255 for the fid
      $create_q = "CREATE TABLE commentator_comments (id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, page VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, uri VARCHAR(255) NOT NULL DEFAULT '', ip TINYTEXT NOT NULL, timestamp INTEGER NOT NULL, comment TEXT NOT NULL, notify TINYINT(1) NOT NULL DEFAULT 0, spam TINYINT(1) NOT NULL DEFAULT 0, rating INTEGER, fid VARCHAR(255)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
      
      $q = mysqli_query($this->link, $create_q);
      $this->process_login();
      if ($_GET['unsubscribe']) $this->unsubscribe($_GET['unsubscribe']);
      elseif ($_POST['mark_comment'] || $_POST['delete_spam']) $this->delete_comments($_POST['mark_comment'], (bool)$_POST['delete_spam']);
      elseif (($_POST['unspam'] || $_POST['spam'] || $_POST['delete_comments']) && empty($_POST['mark_comment'])) $this->alert('No comments selected.');
      else $this->check_submission();
    }
    
    // This should never trigger
    else echo '<p><strong>No MySQL connection set up!</strong></p><p>Make sure you have provided a <code>mysql_connection</code> function for the script to use. There is a sample one for you to use at the bottom of the script - all you need to do is change the parameters to your own.</p>';
    $this->get_comments();
  }

  public $email_regex = '/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
  
  public function process_login() {
  	
  }
  public function check_submission() {
    if ($_POST['submit'] && $_POST['commentator_password'] !== $this->password || $this->preview = $_POST['preview']) {
      list($this->input, $this->invalid) = $this->validate($_POST);
      if (count($this->invalid) === 0 || (count($this->invalid) === 1 && isset($invalid['website']))) {
        $this->review_input = false;
        foreach ($this->input as $key => $value) $$key = trim($value);
        
        /* Geoff recommends commenting this out - we don't have askimet
        if (!empty($this->akismet_file) && $email !== $this->owner_email && !empty($this->wpAPIkey) && @include_once($this->akismet_file)) {
          if (class_exists('Akismet')) {
            $akismet = new Akismet($this->domain, $this->wpAPIkey);
            $akismet->setCommentAuthor($name);
            $akismet->setCommentAuthorEmail($email);
            $akismet->setCommentAuthorURL($website);
            $akismet->setCommentContent($comment);
            $akismet->setPermalink('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $spam = $akismet->isCommentSpam();
          }
        }*/
        
        
        if ($spam || strlen($POST['email_address']) > 0) $spam = 1;
        if ($_POST['remember']) $this->remember = true;
        if ($_POST['notify']) $this->notify = true;
        if ($this->link && !$this->preview) {
        	
        	// this automatically gets the hash table so we should automatically be fed the rating
          foreach ($this->input as $key => $value) {
            $value = trim($value);
            if ($key !== 'comment') $value = strip_tags($value);
            $$key = mysqli_real_escape_string($this->link, $value);
          }
         
         
          // ADDED FID TOO
          
	   	  $prof = $this->tamberFacebook->queryGraph("/me", null);
	      $fid = $prof["id"];
          $q = "INSERT INTO commentator_comments SET page=\"{$this->page}\", name=\"$name\", email=\"$email\", timestamp=\"" . time() . "\", comment=\"$comment\", rating=\"$rating\", fid=\"$fid\"";
          
          
          if ($website) $q .= ", uri=\"$website\"";
          if (!empty($_SERVER['REMOTE_ADDR'])) $q .= ', ip="' . $_SERVER['REMOTE_ADDR'] . '"';
          if ($this->notify) $q .= ', notify=1';
          if ($spam) $q .= ', spam=1';
          if (!mysqli_query($this->link, $q)) echo '<p>Error:' . mysqli_error($this->link) . '</p>';
          else $this->posted = true;

          // send notification - also pretty sure this shit never triggers... Geoff comments it out
          if (!$spam) {
          	
          	
            /*$q = mysqli_query($this->link, "SELECT * FROM commentator_comments WHERE notify=1 AND spam=0 AND page=\"$this->page\"");
            $title = $this->title;
            $subject = "[{$_SERVER['HTTP_HOST']}] New comment on: $title";
            $comment = stripslashes(str_replace(array('\r\n', '\r', '\n'), array("\r\n", "\r", "\n"), $this->format_comment($comment, true))); // fake whitespace turned into real whitespace before stripping slashes added by mysqli_real_escape_string
            $message = "A new comment has been posted on \"$title\".\r\n\r\n{$this->here}\r\n\r\nAuthor: $name\r\n\r\n%sComment:\r\n\r\n$comment\r\n\r\n\r\nAll comments: {$this->here}#comments";
            $headers = "From: {$this->from}\r\nX-Mailer: PHP/" . phpversion();
            */
          	/*
            while ($row = mysqli_fetch_array($q)) {
              $to = $row['email'];
              if ($to === $this->email_owner) continue;
              $mail_result = @mail($to, $subject, $message . "\r\n\r\nTo stop receiving further notifications of new comments: {$this->here}?unsubscribe=$to#comments", $headers);
            }*/
            //if ($GLOBALS['send_email_on_new_comment'] && $this->email_owner !== $email && preg_match($this->email_regex, $this->email_owner)) @mail($this->email_owner, $subject, sprintf($message, "Email: $email\r\n\r\n"), $headers);
          }
        }
      }
      else $this->review_input = true;
    }
  }

  public function validate($input) {
  	
  	// Geoff's modification - needs to check for rating (NOTE Email = Venue)
    $fields = array('name', 'email', 'website', 'comment', 'rating');
    $invalid = array();
    $input = array_map('trim', $input);
    if (get_magic_quotes_gpc() === 1) $input = array_map('stripslashes', $input);
    foreach ($fields as $field) {
    	// Somehow check for if either comment or rating is blank
      if ($field === 'name' || $field === 'comment') {
        if (strlen($input[$field]) < 1) $invalid[$field] = 0;
      }
      elseif ($field === 'website') {
        if (empty($input['website']) || $input['website'] === 'http://') $input['website'] = '';
        else {
          $res = preg_match('@^(https?://)?\b[-\w]+\.[-\w.]+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?@i', $input['website'], $matches);
          if ($res) {
            $pref = strpos($matches[0], 'http://') !== 0 ? 'http://' : '';
            $input['website'] = $pref . $matches[0];
          }
          else $invalid['website'] = 1;
        }
      }
      elseif ($field === 'email') {
        if ($input['email'] === '') $invalid['email'] = 0;
        elseif ($input['email'] === 'Venue...') { $invalid['email'] = 1; }
      }
    }
    $userProfile = $this->tamberFacebook->queryGraph("/me", null);
    $input['name'] = $userProfile['first_name'] . " " . $userProfile['last_name'];
    return array($input, $invalid);
  }

  public function delete_comments($marks, $deleteallspam = false) {
    // No gui for this so we can comment out this method
    // We will have a custom one
  }

  // This is important shit - probably formats the comment for the write method
  public function format_comment($comment, $for_email = false) {
    $comment = preg_replace('@(\r\n|\n|\r)@', '!!QQZZXX!!', $comment);  // replace all newlines with placeholder - hopefully no-one will type !!QQZZXX!! into a comment
    preg_match_all('@<pre>(.*?)</pre>@', $comment, $matches);  // Find all <pre> code blocks and match stuff inside
    if (count($matches[1] > 0)) {
      foreach ($matches[1] as $match) {
        $r = str_replace(array('!!QQZZXX!!', '<', '>'), array("\n", '&lt;', '&gt;'), $match);    // replace < and > in contents of each <pre> block
        if ($for_email) $r = $this->wordwrap_multiline($r, 80 + ((int)$for_email * 30));         // break long lines in <pre> blocks
        $replacement[] = $r;
      }
      $comment = str_replace($matches[1], $replacement, $comment);  // now replace each <pre> block with its corresponsing cleansed version
    }
    if ($for_email) return str_replace(array('&lt;', '&gt;'), array('<', '>'), strip_tags(preg_replace('@(!!QQZZXX!!)+@', "\r\n\r\n", $comment), '<pre><code>')); // replace placeholders with newlines (for emailed comments)
    $comment = preg_replace('@(!!QQZZXX!!)+@', "</p>\n{$this->depth}    <p>", $comment); // replace placeholders with paragraph tags
    if (strpos($comment, '<p') !== 0) $comment = "{$this->depth}    <p>$comment";  // entire comment starts with <p> unless already starting with <p> or <pre>
    switch(strrchr($comment, '/')) {
      case '/pre>': case '/p>': break;
      default: $comment = "$comment</p>\n"; // if comment does not end with </p> or </pre>, stick a </p> on the end
    }
    $comment = $this->paragraphise($this->paragraphise($comment)); // two passes necessary, otherwise things like "</p> text </p>" result
    $comment = strip_tags($comment, (string)$this->allowed_html); // strip all disallowed tags
    if (strlen($this->allowed_html) > 0) {
      if (strpos($this->allowed_html, '<a>') !== false) {
        $tags = str_replace('<a>', '', $this->allowed_html);
      }
      $comment = preg_replace('@<(' . trim(str_replace('><', '|', $tags), '<>') . ')(?:\s+[^\s]*?)?>@', "<$1>", $comment);
    }
    $comment = preg_replace_callback('@<a(?:.+?href=(?:")?([^"]+)(?:"))?.*?>@im', array($this, 'format_links'), $comment); // add nofollow to links and change escaped attribute quotes back
    if (@include_once(dirname(__FILE__) . '/' . $GLOBALS['htmlfixer_file'])) {
      if (class_exists('HtmlFixer')) {
        $a = new HtmlFixer();
        $comment = $a->getFixedHtml($comment);
      }
    }
    if (strrchr($comment, chr(10)) !== chr(10)) $comment .= chr(10);
    return $comment;
  }
  
  private function format_links($m) {
    $rel=' rel="nofollow"';
    if (strpos($m[1], $this->domain) === 0 || strpos($m[1], 'http://') !== 0 && strpos($m[1], 'https://') !== 0) $rel = '';
    return "<a href=\"$m[1]\"$rel>";
  }

  public function wordwrap_multiline($str, $len) {
    $str = explode("\n", $str);
    foreach ($str as $s) $newstr .= wordwrap($s, $len, "\n", true) . "\n";
    return $newstr;
  }

  public function paragraphise($str) {
    $d = $this->depth;
    return preg_replace(array(
      '@</pre>\s*(.+?)\s*<p@',  // </pre> text <p
      '@</pre>\s*(.+?)\s*</p@', // </pre> text </p
      '@(?<=[^>])(\s*<pre>)@',  // text <pre>
      '@<p>(.+?)<p>@',          // <p> text <p>
      '@</p>(.+?)</p>@',        // </p> text </p>
      '@<p>(?:\s*<p>)+@',       // <p>  <p>
      '@</p>(?:\s*</p>)+@',     // </p>  </p>
      '@<p>\s*</p>@',           // <p>  </p>
      '@( *\n *){2,}@'            // Two or more \n
    ), array(
      "</pre>\n$d    <p>$1</p>\n$d    <p",
      "</pre>\n$d    <p>$1</p",
      "</p>\n$d    <pre>",
      "<p>$1</p>\n$d    <p>",
      "</p>\n$d    <p>$1</p>",
      '<p>',
      '</p>',
      '',
      "\n$d    "
    ),
    $str);
  }

  public function ampquot($str) {
    $str = preg_replace('/&(?!amp;|lt;|gt;)/', '&amp;', $str);
    return str_replace('"', '&quot;', $str);
  }
  // End of formatting stuff

  public function get_comments() {
    $spam = ' AND spam=0';
    if ($this->manage === true) {
      $this->show = $_GET['show'];
      if ($this->show === 'spam') $spam = ' AND spam=1';
      elseif ($this->show === 'all') $spam = '';
      $qres = mysqli_query($this->link, "SELECT * FROM commentator_comments WHERE page=\"$this->page\"");
      $this->allcommentscount = mysqli_num_rows($qres);
    }
    if ($this->newest_first === true) $q_append = ' DESC';
    $this->query_comments = mysqli_query($this->link, "SELECT * FROM commentator_comments WHERE page=\"{$this->page}\"$spam ORDER BY timestamp$q_append");
    if (!$this->query_comments) echo '<p>' . mysqli_error($this->link) . '</p>';
    if (!$this->commentcount) $this->commentcount = mysqli_num_rows($this->query_comments);
  }

  // it looks like $this->query_comments is what is going to be formatted
  public function write() {
  	
  	ob_start();
   
  ?>
    <form action="<?php echo $querystring?>#postresult" method="post" id="post_comment">
      <fieldset<?php if ($_POST['commentator_password'] === $this->password) echo ' id="postresult"'?>>
 
<?php if ($this->review_input === true || $this->preview) {
      $errmess = array(
        'name' => array('I need a name!'),
        'email' => array('Venue can\'t be blank', 'Please write a review for a specific venue'),
        'comment' => array('Please write a review', ''),
        'website' => array('', 'That\'s an invalid URI'),
      );
      foreach ($errmess as $field => $err) {
        if (isset($this->invalid[$field])) $errmess[$field] = '<small>' . $err[$this->invalid[$field]] . '</small>';
        else unset($errmess[$field]);
        if ($errmess[$field] === '<small></small>') unset($errmess[$field]);
        $values[$field] = empty($this->input[$field]) ? '' : htmlspecialchars($this->input[$field]);
        if ($field !== 'comment') $values[$field] = ' value="' . $values[$field] . '"';
      }
    }
    elseif ($this->remember && $this->input) { // just posted something (cookie not set yet)
      foreach (array('name', 'email', 'website') as $saved) {
        $values[$saved] = ' value="' . $this->input[$saved] . '"';
      }
    }
    elseif ($_COOKIE['commentator_vars']) {
      if ($_POST['submit'] && !$_POST['remember']) $deletecookie = true;
      else {
        list($cookiedata['name'], $cookiedata['email'], $cookiedata['website']) = explode('|', $_COOKIE['commentator_vars']);
        foreach (array('name', 'email', 'website') as $saved) {
          $values[$saved] = ' value="' . $cookiedata[$saved] . '"';
        }
      }
    }
    if (empty($values['website'])) $values['website'] = ' value="http://"';
    if ($this->preview) {
      $preview = trim($this->format_comment($this->input['comment']));
      if (!$this->review_input) $prid = ' id="postresult"';
      if (!empty($preview)) echo "        <h4>Preview:</h4>\n        <div class=\"commentator-preview\"$prid>\n$preview\n</div>\n";
    }
    if ($this->review_input) echo "        <p id=\"postresult\" class=\"commentator_message\">Please correct the fields indicated below.</p>\n";
?>

		
        
        

        <?php
        if(isset($GLOBALS['user'])){?>
        <input name="name" id="name" type="hidden" value="overwritten"<?php echo $values['name']?>><?php echo $errmess['name']?> 
        
        <input name="email" id="email" type="text" placeholder="Venue..."<?php echo $values['email']?>><?php echo $errmess['email']?> 
        <br>
        <!--  <div class="btn-group" name="rating" id="rating" data-toggle="buttons-radio">
  			<button type="button" class="btn" value="1">Thumbs Down</button>
  			<button type="button" class="btn" value="2">Okay</button>
  			<button type="button" class="btn" value="3">Good</button>
  			<button type="button" class="btn" value="4">Fantastic</button>
  			<button type="button" class="btn" value="5">Killed It</button>
		</div>-->
		<select name="rating" id="rating">
	        <option value="1">Thumbs Down</option>
			<option value="2">Okay</option>
			<option value="3">Good</option>
			<option value="4">Fantastic</option>
			<option value="5">Killed It</option>
		</select>	
        <?php echo $values['rating']?><?php // probably dont want this since its not required echo $errmess['rating']?>
        <textarea name="comment" class ="expand input-xlarge" id="commentarea" placeholder="Write your review here..."><?php echo $values['comment']?></textarea><?php if ($errmess['comment']) echo chr(10) . $this->depth . '' . $errmess['comment']?> 
        <br>
          
        
			
		
		
        
        
        
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
        
        
        <?php }
        
else {

		$loginurl = $this->tamberFacebook->getLoginUrl(array('scope'=>'friends_likes, user_location', 
									'redirect_uri'=>'http://' . $_SERVER['HTTP_HOST']. '/me',
									'display'=>'page'));
		?>
		<h4>Please <?php echo '<a id="login" href="'.$loginurl. '">login</a>' ?> to review.</h4>
		
		
		
		
		<?php }      
        
   echo $this->alertdata;
   // manage will not be true; geoff comments out 
   /*
    if ($this->manage === true) {
      echo "$d<p class=\"commentator-tools\">\n$d  <a href=\"#comments\">Show non-spam</a>\n$d  <a href=\"?show=spam#comments\">Show spam only</a>\n$d  <a href=\"?show=all#comments\">Show everything</a>\n$d</p>\n";
    }*/
    if ($this->query_comments) {
      $d = $this->depth;
      if (($this->spamcount > 0 && $_GET['show'] === 'spam') || ($_GET['show'] !== 'spam' && $this->commentcount > 0)) {
        if ($this->manage === true) {
          echo "$d<form action=\"#comments\" method=\"post\">\n";
          $d .= '  ';
          $c = ' class="manage"';
        }
        echo "$d<p class=\"commentator-pagination\">\n";
        //$GLOBALS['comments_per_page']
        $pagination = is_numeric($perpage = (int)$this->allcommentscount) && $perpage > 0;
        if ($pagination) {
          $pages = (int)ceil($this->commentcount / $perpage);
          $ci = (int)$_GET['ci'];
          if (isset($_GET['ci']) && is_int($ci) && $ci > 0) {
            if ($this->newest_first) $ci = $this->commentcount - $ci;
            $page = (int)ceil($ci / $perpage);
          }
          else $page = (int)$_GET['comments_page'] ? (int)$_GET['comments_page'] : 1;
          $start = (($page-1) * $perpage) + 1;
          if ($pagination && ($pages > 1)) {
            if ($this->manage) $qappend = '&amp;show=' . $this->show;
            if ($_GET['first']) $qappend .= '&amp;first=' . $_GET['first'];
            if ($page > 1) $pstring .= "$d  <a href=\"?comments_page=" . ($page-1) . "$qappend#comments\">&laquo; Previous $perpage</a>\n";
            $pstring .= "$d  Page $page of $pages\n";
            if ($page < $pages) $pstring .= "$d  <a href=\"?comments_page=" . ($page+1) . "$qappend#comments\">Next $perpage &raquo;</a>\n";
            echo $pstring;
          }
        }
        echo "$d</p>\n";
        echo "$d<ol id=\"comments_list\"$c>\n";
        $querystring = !empty($_SERVER['QUERY_STRING']) ? preg_replace('/ci=[^&]+&?/', '', $_SERVER['QUERY_STRING']) : '';
        $querystring = str_replace('commentator-logout', '', $querystring);
        if ($querystring) $querystring = "?$querystring";
        $cur_chrono = $this->newest_first === true ? -1 * ($this->commentcount - $start + 2) : $start - 1;
        $z = 0;
        while ($row = mysqli_fetch_array($this->query_comments, MYSQL_ASSOC)) {
          $z++;
          if ($pagination) {
            if ($z < $start) continue;
            if ($z === (int)($start + $perpage)) break;
          }
          $i = abs(++$cur_chrono);
          
          // GRAVATARS? COMMENT OUT... LATER
          require_once("php/lib/reviewscore.php");
          
          $defgrav = $this->gravatars === true ? '' : '&amp;d=' . (string)$this->gravatars;
          if ($this->gravatars) $avatar = '<img src="http://www.gravatar.com/avatar/' . md5($row['email']) . "?s=32$defgrav\" alt=\"" . $row['name'] . "'s avatar\">";
          $name = htmlspecialchars($row['name']); 
          $title = displayRating($row['rating']). ' </cite>@<cite> ' . $row['email'];
          if (!empty($row['uri'])) {
            if ($this->gravatars) $avatar = '<a href="' . htmlspecialchars($row['uri']) . '" rel="nofollow">' . $avatar . '</a>';
            $name = '<a href="' . htmlspecialchars($row['uri']) . '" rel="nofollow">' . $name; // . '</a>' . ' </cite>@<cite> ' . $row['email'];
          }
          $liclass = $ins = '';
          // it wont be true. ever
          /*
          if ($this->manage === true) {
            $spambox = "$d    <label for=\"mark_comment_" . $row['id'] . "\">Mark this comment for deletion</label><input type=\"checkbox\" name=\"mark_comment[]\" id=\"mark_comment_" . $row['id'] . "\" value=\"" . $row['id'] . "\" title=\"Mark this comment for deletion\">\n";
            $ins .= '<span>' . $row['email'] . '</span>';
            if ($row['notify'] === '1') $ins .= '<span class="notify">Notify</span>';
            if ($row['spam'] === '1') {
              $spamcount++;
              $ins .= "\n$d    <span>" . $row['ip'] . '</span>';
              $liclass = ' class="spam';
            }
          }*/
          
          /*
           * AFTER ALL THAT SHIT, HERE IS WHERE THE WRITING IS. 
           */
          if ($row['email'] === $this->email_owner) $liclass = $liclass ? "$liclass author-comment" : ' class="author-comment';
          if ($z === 1 && $this->posted) $h3id = ' id="postresult"';
          if ($liclass) $liclass .= '"';
          echo "$d  <li id=\"comment-$i\"$liclass>\n$spambox$d    <h4$h3id>\n$d      $avatar\n$d      <cite>$title</cite>$ins\n$d    </h4>\n";
          echo $this->format_comment($row['comment']);
          $qs = $querystring . "ci=$i";
          echo "&ndash; " . $name;
          
          // Credit the first post aight?
          if($name == "Adam Mysorewala" && $row['id'] == 1){
         	 echo "$d    <p>First Post! &ndash; " . date('j F, Y \a\t g:i a', (int)$row['timestamp']) . "</p>\n$d  </li> "; 
          }
          else {
          	 echo "$d    <p>" . date('j F, Y \a\t g:i a', (int)$row['timestamp']) . "</p>\n$d  </li> "; 
          }  
          if(isset($GLOBALS['profile']) && $row['fid'] == $GLOBALS['profile']['id']){
          	echo "<div class='delete-comment' id='" . $row['id'] . "'><a href='#' alt='delete review'>delete</a></div>";
          }
          	

          echo "\n";
          
        }
        echo "$d</ol>\n";
        echo "$d<p class=\"commentator-pagination\">\n$pstring$d</p>\n";
        if ($this->spamcount) $spamcount = $this->spamcount;
        $spaminfo = $spamcount > 0 ? "<input type=\"submit\" name=\"delete_spam\" value=\"Just delete all the spam! ($spamcount)\">" : '<span>Hooray, no spam!</span>';
        if ($this->fake_session) echo "$d<input type=\"hidden\" name=\"commentator_hpw\" value=\"{$this->fake_session}\">\n";
       
        // This won't trigger
        //if ($this->manage) echo "$d<button type=\"submit\" name=\"delete_comments\" value=\"Delete\"><strong>Delete</strong></button>\n$d<input type=\"submit\" name=\"spam\" value=\"Mark as spam\">\n$d<input type=\"submit\" name=\"unspam\" value=\"Unmark as spam\">\n$d$spaminfo\n{$this->depth}</form>\n";
      } else {
      	/* We wont ever have manage = true
        if ($this->manage && $_GET['show'] === 'spam') echo '<p>No spam to report!</p>';
        else {
          if ($this->manage) $mm = ', so nothing to manage';
          echo "$d<p>No comments yet$mm!</p>\n";
        }*/
      }
    }
        
        
        
        
 if ($GLOBALS['preview']) {?>
        <input type="submit" name="preview" value="Preview">
<?php } ?>
        
      </fieldset>
    </form>
<?php
    if ($this->remember && !$this->preview || $deletecookie) {
      $timespan = $deletecookie ? -100000 : 31556926; // the past : 1 year ahead
      echo 'document.cookie="commentator_vars='.$this->input['name'].'|'.$this->input['email'].'|'.$this->input['website'].'; expires=' . date(DATE_COOKIE, time() + $timespan).'";';
    }
    //if (!$this->manage) echo "(function(){var d=document,l=d.getElementById('commentator_login'),a,c,i=l.getElementsByTagName('input');function f(){if(l.f)return;a=l.getElementsByTagName('a')[0];a.firstChild.nodeValue='Admin';l.f=d.createDocumentFragment();l.f.appendChild(i[0]);l.f.appendChild(i[0]);l.normalize();if(c)c.style.display='none';a.onclick=function(){if(l.f){l.insertBefore(l.f,a.parentNode.nextSibling);delete l.f}else return;a.firstChild.nodeValue='Password:';if(!c){c=d.createElement('a');c.href='#cancel_login';c.innerHTML='cancel';c.onclick=f}l.appendChild(c);c.style.display='';i[0].focus();return false};return false};f()})();\n";
    
    $output = ob_get_clean();
    return $output;
  }

  public function unsubscribe($email) {
    $d = $this->depth;
    $correction = "Please check it is correct.</p>\n$d  <form action=\"#comments\" method=\"get\">\n$d    <fieldset>\n$d      <legend>Unsubscribe from comments on this page</legend>\n$d      <label for=\"email_unsub\">Email address:</label> <input type=\"text\" name=\"unsubscribe\" id=\"email_unsub\" value=\"$email\">\n$d      <input type=\"submit\" value=\"Unsubscribe\">\n$d    </fieldset>\n$d  </form>\n";
    if (!preg_match($this->email_regex, $email)) $this->alert("$d  <p><strong>$email</strong> is not a valid email address. " . $correction);
    else {
      mysqli_query($this->link, "UPDATE commentator_comments SET notify=0 WHERE page=\"{$this->page}\" AND email=\"$email\"");
      if (mysqli_affected_rows($this->link) > 0) $this->alert("$d  <p>Success!</p>\n$d  <p>You won't receive any more emails about new comments on this page.</p>\n");
      else $this->alert("$d  <p>It appears your email address is not in the database. $correction");
    }
  }

  public function alert($message) {
    $this->alertdata = $this->depth . '<div class="commentator_message">' . chr(10) . $message . chr(10) . $this->depth . "</div>\n";
  }
}

// SAMPLE MySQL FUNCTION


function mysql_connection() {
  $link = mysqli_connect('localhost', 'tambermu', 'Pr29uwEq$');
  if (!$link) return false; // array(false, 'Connection failed');
  if (!mysqli_set_charset($link, 'utf8')) return false; //array(false, 'Could not set database character set');
  if (!mysqli_select_db($link, 'tambermu_dev')) { 
    echo 'db selection error:' . mysqli_error($link);
    return false; // array(false, 'Could not select database');
  }
  return $link;
}


?>