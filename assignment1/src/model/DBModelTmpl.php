<?php
include_once("IModel.php");
include_once("Book.php");

/** The Model is the class holding data about a collection of books. 
 * @author Rune Hjelsvold
 * @see http://php-html.net/tutorials/model-view-controller-in-php/ The tutorial code used as basis.
 */
class DBModel implements IModel
{        
    /**
      * The PDO object for interfacing the database
      *
      */
    protected $db = null;  
    
    /**
	 * @throws PDOException
     */
    public function __construct($db = null)  
    {  	
	    if ($db) 
		{
			$this->db = $db;
		}
		else
		{
            // Create PDO connection
			try {
				// A new PDO object is connecting to a local MySQL- server, where the
				// database is named "test", unicode is "utf8", username is "root" without any password.
				// Also the PDO object is set in "exception mode".
				$this->db = new PDO('mysql:host=localhost; dbname=test; charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				// If something goes wrong during the connecting process, a PDO exception is thrown.
				// A PDO exception thrown results in an error page. 
				// An error page is created here in the model because otherwise it will not get caught
				// in the application running in the browser.
			} catch(PDOException $ex) {
				$view = new ErrorView("Failed to connect to the database: " . $ex->getMessage());
				$view->create();
				exit();
			}
		}
    }
    
    /** Function returning the complete list of books in the collection. Books are
     * returned in order of id.
     * @return Book[] An array of book objects indexed and ordered by their id.
	 * @throws PDOException
     */
    public function getBookList()
    {	
		try {
			// All registered records are retrieved from the database and fetched into
			// a local array, which is returned (displayed to the view).
			$booklist = array();
			foreach ($this->db->query('SELECT * FROM Book ORDER BY id') as $row) {
				array_push($booklist, new Book($row['title'], $row['author'], $row['description'], $row['id']));
			}
			return $booklist;
			//If something goes wrong during the retrieval process, a PDO exception is thrown.
			// A PDO exception thrown is thrown to the controller.
		} catch(PDOException $ex) {
			throw $ex;
		}
    }
    
    /** Function retrieving information about a given book in the collection.
     * @param integer $id the id of the book to be retrieved
     * @return Book|null The book matching the $id exists in the collection; null otherwise.
	 * @throws PDOException
     */
    public function getBookById($id)
    {	
		try {
			// Do a query if the provided id is indeed an integer.
			if (is_numeric($id)) {
				$row = $this->db->query("SELECT * FROM Book WHERE id=$id")->fetch(PDO::FETCH_ASSOC);
				// If data was succesfully returned from the query, the matching book is returned
				// as a new Book object. Else null is returned.
				if ($row) {
					return new Book($row['title'], $row['author'], $row['description'], $row['id']);
				} else {
					return null;
				}
				// If the id is not an integer, a PDO expection is thrown.
			} else {
				throw new PDOException("Id is not a number.\n");
			}
			//A PDO exception thrown is thrown to the controller.
		} catch(PDOException $ex){
			throw $ex;
		}
	} 
    
    /** Adds a new book to the collection.
     * @param $book Book The book to be added - the id of the book will be set after successful insertion.
	 * @throws PDOException
     */
    public function addBook($book)
    {
		try {
			// If both a title and an author is provided by the user, the SQL statement
			// is being prepared and binded with the user- provded values, then lastInsertID 
			// is returned to the book's id (auto_increment).
			if ($book->title && $book->author) {
				$stmt = $this->db->prepare('INSERT INTO Book (title, author, description)'
				      						. 'VALUES(:title, :author, :description)');
				$stmt->bindValue(':title', $book->title);
				$stmt->bindValue(':author', $book->author);
				$stmt->bindValue(':description', $book->description);
				$stmt->execute();
				$book->id = $this->db->lastInsertId();
				// If title and/ or author is not provided, a PDO exception is thrown.
			} else {						
				throw new PDOException("Title and/ or author missing!\n");
			}
			//A PDO Exception thrown is thrown to the controller.
		} catch(PDOException $ex) {
			throw $ex;
		}
    }

    /** Modifies data related to a book in the collection.
     * @param $book Book The book data to be kept.
     * @todo Implement function using PDO and a real database.
     */
    public function modifyBook($book)
    {
		try {
			// If both a title and an author is provided by the user, the SQL statement
			// is being prepared and binded/ executed with the user- provided values.
			// Otherwise a PDOException is thrown.
			if (!$book->title || !$book->author) {
				throw new PDOException("Title and/ or author missing!\n");
			}
				$stmt = $this->db->prepare('UPDATE Book SET title=?, author=?, description=?' 
										    . 'WHERE id=?');						   
				$stmt->execute(array($book->title, $book->author, $book->description, $book->id));
			//A PDO Exception thrown is thrown to the controller.
		} catch(PDOException $ex) {
			throw $ex;
		}
    }

	
    /** Deletes data related to a book from the collection.
     * @param $id integer The id of the book that should be removed from the collection.
     */
    public function deleteBook($id)
    {
		try {
			// The SQL statement is being prepared and binded with the user- provided values.
			$stmt = $this->db->prepare('DELETE FROM Book WHERE id=:id');
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			// If something goes wrong during the SQL statement, a PDO Exception is thrown.
			// A PDO exception thrown is thrown to the controller.
		} catch(PDOException $ex) {
			throw $ex;
		}
    }
	
}

?>
