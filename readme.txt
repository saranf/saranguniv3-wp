워드프레스를 이용해서 만든 교회홈페이지(하이브리드)

local에서 호스팅으로 옮길때

1. wp-content\themes\sydney\functions.php 에서 
update_option('siteurl','localhost/wordpress');
update_option('home','localhost/wordpress');
이 소스를 주석처리 또는 제거해주세요.

2. wp-login.php에서 관리자계정으로 로그인 한뒤 wp-admin에 들어가서
설정-일반 사이트주소를 호스팅주소로 변경해주세요

3. 외모-메뉴에 들어가서 사용자 정의 링크에 URL를 호스팅주소로 변경해주세요.

로그아웃 상태에서 admin toolbar를 표시하기위해서 버디프레스(BuddyPress) 플러그인을 설치했습니다.
설정-버디프레스-옵션에서 로그아웃 사용자에게 툴바 보이기를 체크하면 로그아웃 상태에서도 툴바가 보이게 됩니다.


워드프레스 플러그인은 db에 저장됩니다.

게시판 플러그인(KBoard)을 추가했습니다.
주소:http://www.cosmosfarm.com/products/kboard