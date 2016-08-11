# 라라벨 웹 프레임워크로 "막무가내" 블로그 만들기

페이스북으로 중계한 라이브 코딩에서 만든 결과물입니다.

## 1. 목적

페이스북 라이브는

-   남들이 개발하는 모습을 지켜보는 것도 도움이된다는 믿음
-   제가 코딩한지 좀 되서 "감"을 다시 찾기 위한 목적
-   페이스북 라이브의 유용성, 가능성을 검증하기 위한 목적

으로 했습니다.

**`안내`** 영상에서는 프레임워크의 기본 기능 또는 개념에 대해 자세히 설명하지 않습니다.

## 2. 라이브 코딩 영상

-   [1편 - 오프닝, Database migration, Model factory, Database seeder](https://www.facebook.com/juwonkimatmedotcom/videos/10202001156626674/)
-   [2편 - Model & Relationships, 글 목록, 글 상세 보기](https://www.facebook.com/juwonkimatmedotcom/videos/10202001339431244/)
-   [3편 - 새 글 작성 폼 및 처리 로직](https://www.facebook.com/juwonkimatmedotcom/videos/10202008678054705/)
-   [4편 - 글 수정 및 삭제](https://www.facebook.com/juwonkimatmedotcom/videos/10202009028823474/)
-   다음 편 라이브 일정은 페이스북을 통해 공개하도록 하겠습니다. 다음 편에서는 댓글 기능을 만듭니다(시간이 되면 테스트 코드도 작성하겠습니다).

## 3. 설치법

이하 워크플로우는 라라벨을 이용해서 만든 대부분의 프로젝트를 초기화하는 일반적인 방법입니다.

#### 3.1. 프로젝트 복제

프로젝트를 복제(다운로드)합니다.

```sh
$ git clone git@github.com:appkr/foo-blog-live.git

# 깃허브에 SSH 키를 등록하지 않은 분은
$ git clone https://github.com/appkr/foo-blog-live.git
```

#### 3.2. 의존성 설치

프로젝트가 의존하는 라이브러리를 설치합니다.

```sh
$ cd foo-blog-live

# composer를 포함해 개발환경이 없는 분은 이 링크를 참고하세요.
# https://appkr.github.io/l5book-snippets/draft/a0-setup.html
foo-blog-live $ composer install
```

#### 3.3. 환경변수

`.env.example` 파일을 복사해서 `.env` 파일을 만듭니다. 또, 프로젝트에 사용할 암호화 키를 만듭니다.

```sh
foo-blog-live $ cp .env.example .env
foo-blog-live $ php artisan key:generate
```

`.env`를 열어 데이터베이스 접속 관련 설정을 변경합니다. `DB_DATABASE`, `DB_USERNAME` 값을 `foo`로 변경했습니다.

```sh
# .env

DB_CONNECTION="mysql"
DB_HOST="127.0.0.1"
DB_PORT=3306
DB_DATABASE="foo"
DB_USERNAME="foo"
DB_PASSWORD="secret"
```

#### 3.4. 데이터베이스

데이터베이스와 사용자를 생성합니다.

```sh
foo-blog-live $ mysql -uroot -p
# Enter password:
# Welcome to the MySQL monitor. ...
mysql> CREATE DATABASE foo;
mysql> CREATE USER 'foo'@'localhost' IDENTIFIED BY 'secret';
mysql> GRANT ALL PRIVILEGES ON *.* TO 'foo'@'localhost';
mysql> FLUSH PRIVILEGES;
mysql> quit
foo-blog-live $
```

#### 3.5. 마이그레이션과 시딩

테이블 스키마를 만들고, 테스트 데이터를 심습니다.

```sh
foo-blog-live $ php artisan migrate:refresh --seed
```

#### 3.6. 확인

로컬 서버를 구동하고 작동을 확인합니다.

```sh
foo-blog-live $ php artisan serve
# Laravel development server started on http://localhost:8000/
```

브라우저에서 `http://localhost:8000/` 주소를 열어 확인합니다.

## 4. 소스 싱크

이미 3절의 과정을 진행하신 분은 다음 명령으로 최신 소스코드를 받을 수 있습니다.

```sh
foo-blog-live $ git pull
```
