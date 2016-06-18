<?
if(!isset($_SESSION))
	session_start();
?>
<html>
<head>
	<style>

		* { margin:0; padding:0; font-family:"바탕",'Ubuntu','맑은 고딕',serif; }
		body a:link{color:black;}
		body a:visited{color:black;}
		a { text-decoration:none; }
		li { list-style:none; }
		img {border:0; }

		#menu-wrapper { background-color:#ffccb2; padding: 10px 20px; position:fixed; width:100%; }
		#main-navigation { padding:5px; overflow:auto; }
		#content-wrapper { padding:0 50px 0 50px; background-color:#FFF0F0; overflow:auto;}
		#content {margin: 0 auto;}
		#left { background-color: white; overflow:auto; height:500px; width:200px; float:left; margin:10px 10px 0 10px; padding-top:70px;}
		#middle { background-color:white; overflow:auto; height:1000px; width:700px; float:left; margin : 10px 0 0 0; padding-top:70px;}
		#right { background-color:white; overflow:auto; height:500px; width:300px; float:left; margin:10px 0 0 10px; padding-top:70px;}

		.search-input { padding:5px 0 0 0; float:right;}
		.search {float:right; padding:3px 25px 0 10px;}
		.friend {float:left; padding: 0 10px 0 10px;}
		.home {float:left; padding: 0 10px 0 10px;}
		.user {float:left; padding:15px 10px 0 10px;}

	</style>
	<title>
	</title>
</head>
<body>
	<div id=page>
		<div id = menu-wrapper>
			<div id = main-navigation>
				<div id = top-menu>
					<div class = search> <img src="../img/search.png" width="35">  </div>
					<div class = search-input> <input type=text name=search size="40" style="height:30px">  </div>
					<div class = home> <img src="../img/home.png" width="40"></div>
					<div class = friend> <img src="../img/friend.png" width="50"></div>
					<div class = user> 현재 사용자 정보 </div>
				</div>
			</div>
		</div>

		<div id = content-wrapper>
			<div id = content>
				<div id = left>
				왼쪽메뉴
				</div>
				<div id = middle>
				컨텐츠
				</div>
				<div id = right>
				오른쪽(?)
				<div id = footer>
				</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
